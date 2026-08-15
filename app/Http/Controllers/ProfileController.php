<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $profileData = $this->getProfileData($user);
        
        return view('pages.profile.index', compact('user', 'profileData'));
    }

    /**
     * Update profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:1|max:150',
            'gender' => 'nullable|in:male,female,other',
            'height' => 'nullable|numeric|min:50|max:300',
            'weight' => 'nullable|numeric|min:10|max:500',
            'fitness_goal' => 'nullable|string',
            'activity_level' => 'nullable|string',
            'medical_notes' => 'nullable|string',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);
        
        // Handle photo upload
        // $path = $request->file('photo')->store('profiles', 'public');
        // auth()->user()->update(['profile_photo' => $path]);
        
        return redirect()->route('profile.index')
            ->with('success', 'Photo updated successfully!');
    }

    /**
     * Get profile data.
     *
     * @param  \App\Models\User  $user
     * @return array
     */
    private function getProfileData($user)
    {
        return [
            'age' => 25,
            'gender' => 'Male',
            'height' => 175,
            'weight' => 75.5,
            'bmi' => 22.4,
            'fitness_goal' => 'Build Muscle',
            'activity_level' => 'Moderately Active',
            'medical_notes' => '',
            'member_since' => $user->created_at,
        ];
    }

    /**
     * Calculate BMI.
     *
     * @param  float  $weight
     * @param  float  $height
     * @return float
     */
    private function calculateBMI($weight, $height)
    {
        if ($height <= 0) return 0;
        $heightInMeters = $height / 100;
        return round($weight / ($heightInMeters * $heightInMeters), 1);
    }
}