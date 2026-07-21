<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display the calendar page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $events = $this->getEvents($currentMonth, $currentYear);
        
        return view('pages.calendar.index', compact('events', 'currentMonth', 'currentYear'));
    }

    /**
     * Get events for a specific month.
     *
     * @param  int  $month
     * @param  int  $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents($month, $year)
    {
        $events = $this->getEventsForMonth($month, $year);
        return response()->json($events);
    }

    /**
     * Add a new event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addEvent(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string',
            'type' => 'required|in:workout,meal,rest,reminder',
            'notes' => 'nullable|string',
        ]);
        
        // Save event
        // CalendarEvent::create($validated + ['user_id' => auth()->id()]);
        
        return response()->json([
            'success' => true,
            'message' => 'Event added successfully!'
        ]);
    }

    /**
     * Get events for a month.
     *
     * @param  int  $month
     * @param  int  $year
     * @return array
     */
    private function getEventsForMonth($month, $year)
    {
        return [
            ['day' => 5, 'title' => 'HIIT Workout', 'type' => 'workout'],
            ['day' => 7, 'title' => 'Meal Prep', 'type' => 'meal'],
            ['day' => 12, 'title' => 'Yoga Session', 'type' => 'workout'],
            ['day' => 15, 'title' => 'Rest Day', 'type' => 'rest'],
            ['day' => 20, 'title' => 'Strength Training', 'type' => 'workout'],
            ['day' => 25, 'title' => 'Cardio Session', 'type' => 'workout'],
            ['day' => 28, 'title' => 'Progress Check', 'type' => 'reminder'],
        ];
    }
}