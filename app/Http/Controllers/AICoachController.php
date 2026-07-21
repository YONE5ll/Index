<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AICoachController extends Controller
{
    /**
     * Display the AI Coach chat interface.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $conversations = $this->getConversations();
        $suggestedPrompts = $this->getSuggestedPrompts();
        
        return view('pages.ai-coach.index', compact('conversations', 'suggestedPrompts'));
    }

    /**
     * Handle chat message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'conversation_id' => 'nullable|integer',
        ]);
        
        // Process message with AI
        $response = $this->getAIResponse($request->message);
        
        // Save conversation
        // Conversation::create([
        //     'user_id' => auth()->id(),
        //     'message' => $request->message,
        //     'response' => $response,
        //     'conversation_id' => $request->conversation_id,
        // ]);
        
        return response()->json([
            'success' => true,
            'message' => $response,
            'conversation_id' => rand(1, 1000), // In real app, this would be from DB
        ]);
    }

    /**
     * Get conversations list.
     *
     * @return array
     */
    private function getConversations()
    {
        return [
            [
                'id' => 1,
                'title' => 'Workout Plan Help',
                'last_message' => 'Can you help me with a workout plan?',
                'time' => '2 hours ago',
                'active' => true
            ],
            [
                'id' => 2,
                'title' => 'Nutrition Advice',
                'last_message' => 'What should I eat after a workout?',
                'time' => 'Yesterday',
                'active' => false
            ],
            [
                'id' => 3,
                'title' => 'Form Check',
                'last_message' => 'Is my squat form correct?',
                'time' => '3 days ago',
                'active' => false
            ],
        ];
    }

    /**
     * Get suggested prompts.
     *
     * @return array
     */
    private function getSuggestedPrompts()
    {
        return [
            'Create a workout plan for me',
            'How to improve my deadlift form?',
            'Best post-workout meal',
            'What\'s a good warm-up routine?',
            'How to stay motivated?',
            'Tips for better sleep',
        ];
    }

    /**
     * Get AI response (mock).
     *
     * @param  string  $message
     * @return string
     */
    private function getAIResponse($message)
    {
        $responses = [
            "Great question! I'd recommend starting with a balanced workout routine. Try 3-4 days per week focusing on compound movements.",
            "For nutrition, aim for a balanced diet with plenty of protein, healthy fats, and complex carbohydrates. Stay hydrated!",
            "Form is crucial! Remember to keep your back straight, core engaged, and move with control. Consider working with a trainer for guidance.",
            "Excellent question! Consistency is key. Start small, track your progress, and celebrate your wins along the way.",
            "Here's a sample workout plan:\n- Monday: Upper body\n- Wednesday: Lower body\n- Friday: Full body\n- Sunday: Active recovery",
            "Remember to warm up properly before each workout. 5-10 minutes of light cardio and dynamic stretching can prevent injuries.",
        ];
        
        return $responses[array_rand($responses)];
    }
}