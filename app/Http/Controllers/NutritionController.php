<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NutritionController extends Controller
{
    /**
     * Display the nutrition dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'dailyCalories' => ['consumed' => 1845, 'target' => 2200],
            'protein' => ['consumed' => 125, 'target' => 150],
            'carbs' => ['consumed' => 220, 'target' => 250],
            'fat' => ['consumed' => 45, 'target' => 65],
            'water' => ['consumed' => 1.8, 'target' => 3],
            'meals' => $this->getMeals(),
            'weeklyData' => $this->getWeeklyNutritionData(),
            'recentFoods' => $this->getRecentFoods(),
        ];
        
        return view('pages.nutrition.index', $data);
    }

    /**
     * Display the food tracking page.
     *
     * @return \Illuminate\View\View
     */
    public function track()
    {
        return view('pages.nutrition.track');
    }

    /**
     * Log a food item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function log(Request $request)
    {
        $validated = $request->validate([
            'food_name' => 'required|string',
            'calories' => 'required|integer|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
        ]);
        
        // Log food to database
        // FoodLog::create($validated + ['user_id' => auth()->id(), 'logged_at' => now()]);
        
        return response()->json([
            'success' => true,
            'message' => 'Food logged successfully!'
        ]);
    }

    /**
     * Search for foods.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchFood(Request $request)
    {
        $query = $request->get('query');
        
        // Search in food database
        // $foods = Food::where('name', 'LIKE', "%{$query}%")->limit(10)->get();
        
        // Sample results
        $foods = [
            ['id' => 1, 'name' => 'Chicken Breast', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
            ['id' => 2, 'name' => 'Brown Rice', 'calories' => 216, 'protein' => 5, 'carbs' => 45, 'fat' => 1.8],
            ['id' => 3, 'name' => 'Salmon', 'calories' => 208, 'protein' => 22, 'carbs' => 0, 'fat' => 13],
        ];
        
        return response()->json(['results' => $foods]);
    }

    /**
     * Get meals for the day.
     *
     * @return array
     */
    private function getMeals()
    {
        return [
            'breakfast' => [
                ['name' => 'Oatmeal', 'calories' => 250, 'protein' => 10, 'carbs' => 35, 'fat' => 5],
                ['name' => 'Banana', 'calories' => 105, 'protein' => 1, 'carbs' => 27, 'fat' => 0.4],
            ],
            'lunch' => [
                ['name' => 'Chicken Salad', 'calories' => 350, 'protein' => 30, 'carbs' => 20, 'fat' => 15],
            ],
            'dinner' => [
                ['name' => 'Grilled Salmon', 'calories' => 400, 'protein' => 35, 'carbs' => 10, 'fat' => 22],
                ['name' => 'Quinoa', 'calories' => 220, 'protein' => 8, 'carbs' => 39, 'fat' => 3.5],
            ],
            'snacks' => [
                ['name' => 'Greek Yogurt', 'calories' => 120, 'protein' => 12, 'carbs' => 8, 'fat' => 4],
            ],
        ];
    }

    /**
     * Get weekly nutrition data.
     *
     * @return array
     */
    private function getWeeklyNutritionData()
    {
        return [
            'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'calories' => [1800, 2100, 1950, 2200, 2050, 2400, 1900],
            'protein' => [120, 150, 130, 145, 140, 160, 125],
            'carbs' => [200, 230, 210, 240, 220, 250, 190],
        ];
    }

    /**
     * Get recent foods.
     *
     * @return array
     */
    private function getRecentFoods()
    {
        return [
            ['name' => 'Chicken Breast', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
            ['name' => 'Brown Rice', 'calories' => 216, 'protein' => 5, 'carbs' => 45, 'fat' => 1.8],
            ['name' => 'Salmon', 'calories' => 208, 'protein' => 22, 'carbs' => 0, 'fat' => 13],
            ['name' => 'Avocado', 'calories' => 160, 'protein' => 2, 'carbs' => 9, 'fat' => 15],
        ];
    }
}