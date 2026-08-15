<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $settings = $this->getSettings($user);
        
        return view('pages.settings.index', compact('user', 'settings'));
    }

    /**
     * Update settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'in:light,dark',
            'notifications_email' => 'boolean',
            'notifications_workout' => 'boolean',
            'notifications_achievement' => 'boolean',
            'language' => 'string|in:en,es,fr,de',
            'units' => 'string|in:metric,imperial',
            'privacy' => 'string|in:public,private,friends',
        ]);
        
        // Save settings to database
        // $user = auth()->user();
        // $user->settings()->update($validated);
        
        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Update password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('settings.index')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Delete user account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        $user = Auth::user();
        
        // Logout user
        Auth::logout();
        
        // Delete user
        $user->delete();
        
        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Account deleted successfully.');
    }

    /**
     * Get user settings.
     *
     * @param  \App\Models\User  $user
     * @return array
     */
    private function getSettings($user)
    {
        return [
            'theme' => 'light',
            'notifications_email' => true,
            'notifications_workout' => true,
            'notifications_achievement' => false,
            'language' => 'en',
            'units' => 'metric',
            'privacy' => 'public',
        ];
    }
}