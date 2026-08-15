<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeDay;
use App\Models\UserChallengeProgress;
use App\Models\UserChallengeDayProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChallengeController extends Controller
{
    /**
     * Display a listing of challenges.
     */
    public function index(Request $request)
    {
        $query = Challenge::active();

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        $challenges = $query->paginate(9);

        // Get user's active challenges
        $userChallenges = [];
        if (auth()->check()) {
            $userChallenges = UserChallengeProgress::where('user_id', auth()->id())
                ->whereIn('status', [0, 1]) // Not started or in progress
                ->with('challenge')
                ->get();
        }

        // Get available challenges (not joined by user)
        $availableChallenges = $challenges->filter(function($challenge) {
            return !$challenge->is_joined;
        });

        return view('pages.challenges.index', compact(
            'challenges',
            'userChallenges',
            'availableChallenges'
        ));
    }

    /**
     * Display a specific challenge.
     */
    public function show($id)
    {
        $challenge = Challenge::with(['days'])->findOrFail($id);
        
        // Get user's progress
        $progress = null;
        $dayProgress = [];
        
        if (auth()->check()) {
            $progress = UserChallengeProgress::where('user_id', auth()->id())
                ->where('challenge_id', $id)
                ->first();
            
            if ($progress) {
                $dayProgress = UserChallengeDayProgress::where('user_id', auth()->id())
                    ->where('challenge_id', $id)
                    ->get()
                    ->keyBy('day_number');
            }
        }

        // Check if user has joined
        $isJoined = $progress !== null;

        return view('pages.challenges.show', compact(
            'challenge',
            'progress',
            'dayProgress',
            'isJoined'
        ));
    }

    /**
     * Join a challenge.
     */
    public function join($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $challenge = Challenge::findOrFail($id);
        
        // Check if already joined
        $existing = UserChallengeProgress::where('user_id', auth()->id())
            ->where('challenge_id', $id)
            ->first();

        if ($existing) {
            return redirect()->route('challenges.show', $id)
                ->with('info', 'You have already joined this challenge!');
        }

        // Create progress record
        $progress = UserChallengeProgress::create([
            'user_id' => auth()->id(),
            'challenge_id' => $id,
            'started_at' => now(),
            'status' => 1, // In progress
            'current_day' => 0,
            'completed_days' => 0,
            'day_completions' => [],
            'streak' => 0,
        ]);

        // Increment participants count
        $challenge->increment('participants');

        return redirect()->route('challenges.show', $id)
            ->with('success', '🎉 You have joined the challenge! Good luck!');
    }

    /**
     * Complete a challenge day.
     */
    public function completeDay(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'day_number' => 'required|integer|min:1',
            'duration' => 'nullable|integer|min:1',
            'calories_burned' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $challenge = Challenge::findOrFail($id);
        $dayNumber = $request->day_number;

        // Check if day exists
        $challengeDay = ChallengeDay::where('challenge_id', $id)
            ->where('day_number', $dayNumber)
            ->first();

        if (!$challengeDay) {
            return response()->json(['error' => 'Day not found'], 404);
        }

        // Get or create progress
        $progress = UserChallengeProgress::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'challenge_id' => $id,
            ],
            [
                'started_at' => now(),
                'status' => 1,
                'current_day' => 0,
                'completed_days' => 0,
                'day_completions' => [],
                'streak' => 0,
            ]
        );

        // Check if day already completed
        $dayProgress = UserChallengeDayProgress::where('user_id', auth()->id())
            ->where('challenge_id', $id)
            ->where('day_number', $dayNumber)
            ->first();

        if ($dayProgress && $dayProgress->is_completed) {
            return response()->json(['error' => 'Day already completed'], 400);
        }

        DB::transaction(function () use ($request, $challenge, $dayNumber, $progress, $challengeDay) {
            // Create day progress
            UserChallengeDayProgress::create([
                'user_id' => auth()->id(),
                'challenge_id' => $challenge->id,
                'challenge_day_id' => $challengeDay->id,
                'day_number' => $dayNumber,
                'is_completed' => true,
                'completed_date' => now(),
                'duration' => $request->duration,
                'calories_burned' => $request->calories_burned,
                'notes' => $request->notes,
            ]);

            // Update main progress
            $dayCompletions = $progress->day_completions ?? [];
            $dayCompletions[] = $dayNumber;
            
            $completedDays = count(array_unique($dayCompletions));
            
            // Check if all days are completed
            $totalDays = $challenge->days->count();
            $status = $completedDays >= $totalDays ? 2 : 1; // 2=completed, 1=in progress

            $progress->update([
                'current_day' => $dayNumber,
                'completed_days' => $completedDays,
                'day_completions' => $dayCompletions,
                'status' => $status,
                'completed_at' => $status == 2 ? now() : null,
                'total_calories_burned' => $progress->total_calories_burned + ($request->calories_burned ?? 0),
                'total_duration' => $progress->total_duration + ($request->duration ?? 0),
                'streak' => $this->calculateStreak($dayCompletions),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Day completed! 🎉',
            'completed_days' => $progress->fresh()->completed_days,
            'progress_percentage' => $progress->fresh()->progress_percentage,
            'streak' => $progress->fresh()->streak,
        ]);
    }

    /**
     * Calculate current streak.
     */
    private function calculateStreak($completedDays)
    {
        if (empty($completedDays)) return 0;
        
        sort($completedDays);
        $streak = 1;
        $current = 1;
        
        for ($i = 1; $i < count($completedDays); $i++) {
            if ($completedDays[$i] == $completedDays[$i-1] + 1) {
                $current++;
            } else {
                $current = 1;
            }
            $streak = max($streak, $current);
        }
        
        return $streak;
    }

    /**
     * Get challenge progress for AJAX.
     */
    public function getProgress($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $progress = UserChallengeProgress::where('user_id', auth()->id())
            ->where('challenge_id', $id)
            ->first();

        if (!$progress) {
            return response()->json(['error' => 'Not joined'], 404);
        }

        $dayProgress = UserChallengeDayProgress::where('user_id', auth()->id())
            ->where('challenge_id', $id)
            ->get()
            ->map(function($day) {
                return [
                    'day_number' => $day->day_number,
                    'is_completed' => $day->is_completed,
                    'completed_date' => $day->completed_date ? $day->completed_date->format('Y-m-d') : null,
                    'duration' => $day->duration,
                    'calories_burned' => $day->calories_burned,
                ];
            });

        return response()->json([
            'progress' => [
                'completed_days' => $progress->completed_days,
                'total_days' => $progress->challenge->duration,
                'progress_percentage' => $progress->progress_percentage,
                'status' => $progress->status_text,
                'streak' => $progress->streak,
                'total_calories' => $progress->total_calories_burned,
                'total_duration' => $progress->total_duration,
                'days_left' => $progress->days_left,
            ],
            'day_progress' => $dayProgress,
        ]);
    }

    /**
     * Get challenge statistics.
     */
    public function getStats($id)
    {
        $challenge = Challenge::findOrFail($id);
        
        $stats = [
            'total_participants' => $challenge->participants,
            'total_completed' => UserChallengeProgress::where('challenge_id', $id)
                ->where('status', 2)
                ->count(),
            'average_rating' => UserChallengeProgress::where('challenge_id', $id)
                ->whereNotNull('rating')
                ->avg('rating'),
            'average_completion_time' => UserChallengeProgress::where('challenge_id', $id)
                ->whereNotNull('completed_at')
                ->avg(DB::raw('DATEDIFF(completed_at, started_at)')),
        ];

        return response()->json($stats);
    }

    /**
     * Leave/abandon a challenge.
     */
    public function leave($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $progress = UserChallengeProgress::where('user_id', auth()->id())
            ->where('challenge_id', $id)
            ->first();

        if (!$progress) {
            return redirect()->route('challenges.index')
                ->with('error', 'You are not participating in this challenge.');
        }

        $progress->update([
            'status' => 3, // Abandoned
        ]);

        return redirect()->route('challenges.index')
            ->with('info', 'You have left the challenge.');
    }
}