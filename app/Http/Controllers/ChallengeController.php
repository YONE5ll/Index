<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Display the challenges page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $challenges = $this->getChallenges();
        $userChallenges = $this->getUserChallenges();
        
        return view('pages.challenges.index', compact('challenges', 'userChallenges'));
    }

    /**
     * Display a specific challenge.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $challenge = $this->getChallengeDetails($id);
        return view('pages.challenges.show', compact('challenge'));
    }

    /**
     * Join a challenge.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join($id)
    {
        // Join challenge
        // UserChallenge::create([
        //     'user_id' => auth()->id(),
        //     'challenge_id' => $id,
        //     'joined_at' => now(),
        // ]);
        
        return redirect()->route('challenges.show', $id)
            ->with('success', 'You have joined the challenge!');
    }

    /**
     * Get challenges.
     *
     * @return array
     */
    private function getChallenges()
    {
        return [
            [
                'id' => 1,
                'name' => '30-Day Beginner Plan',
                'description' => 'Perfect for beginners starting their fitness journey. Build habits and gain confidence.',
                'difficulty' => 'Beginner',
                'duration' => '30 days',
                'participants' => 1245,
                'progress' => 0,
                'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop',
                'featured' => true
            ],
            [
                'id' => 2,
                'name' => 'Push-Up Challenge',
                'description' => 'Build upper body strength with daily push-up progressions.',
                'difficulty' => 'Intermediate',
                'duration' => '30 days',
                'participants' => 876,
                'progress' => 45,
                'image' => 'https://images.unsplash.com/photo-1570824104453-508955ab713e?w=400&h=300&fit=crop',
                'featured' => false
            ],
            [
                'id' => 3,
                'name' => '10K Steps Daily',
                'description' => 'Stay active with a goal of 10,000 steps every day for 30 days.',
                'difficulty' => 'Beginner',
                'duration' => '30 days',
                'participants' => 2134,
                'progress' => 0,
                'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=400&h=300&fit=crop',
                'featured' => false
            ],
        ];
    }

    /**
     * Get user's active challenges.
     *
     * @return array
     */
    private function getUserChallenges()
    {
        return [
            [
                'name' => '30-Day Beginner Plan',
                'progress' => 60,
                'days_left' => 12,
                'completed' => false
            ],
            [
                'name' => 'Push-Up Challenge',
                'progress' => 45,
                'days_left' => 17,
                'completed' => false
            ],
        ];
    }

    /**
     * Get challenge details.
     *
     * @param  int  $id
     * @return array
     */
    private function getChallengeDetails($id)
    {
        return [
            'id' => $id,
            'name' => '30-Day Beginner Plan',
            'description' => 'This 30-day plan is designed for beginners to build a consistent fitness habit. Each day includes a simple workout that progresses in difficulty.',
            'difficulty' => 'Beginner',
            'duration' => '30 days',
            'participants' => 1245,
            'progress' => 60,
            'days' => $this->getChallengeDays(),
            'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&h=400&fit=crop',
            'rules' => [
                'Complete the daily workout',
                'Log your progress each day',
                'Take a rest day when needed',
                'Stay hydrated and eat well',
            ]
        ];
    }

    /**
     * Get challenge days.
     *
     * @return array
     */
    private function getChallengeDays()
    {
        $days = [];
        $exercises = ['Push-ups', 'Squats', 'Planks', 'Lunges', 'Burpees', 'Mountain Climbers'];
        
        for ($i = 1; $i <= 30; $i++) {
            $days[] = [
                'day' => $i,
                'workout' => $exercises[array_rand($exercises)],
                'exercises' => [
                    ['name' => 'Push-ups', 'sets' => 3, 'reps' => '10-15'],
                    ['name' => 'Squats', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Planks', 'sets' => 3, 'reps' => '30 seconds'],
                ],
                'sets' => 3,
                'reps' => '10-15',
                'calories' => rand(80, 150),
                'duration' => rand(15, 30),
                'completed' => $i <= 18 ? true : false,
            ];
        }
        
        return $days;
    }
}