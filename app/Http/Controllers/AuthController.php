<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('super-admin.login');
    }

    // Handle the login logic
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check the credentials
        $user = User::where('email', $request->email)->first();

        // If user exists and password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication is successful, log the user in
            Auth::login($user);

            // Set a session flash message for the welcome
            session()->flash('welcome_message', 'Welcome back, '.$user->name.'!');

            // Redirect to a protected page or dashboard
            return redirect()->route('pdrrmo-home.index');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle the logout logic
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the authenticated user

        // Optionally invalidate and regenerate the session to prevent session fixation attacks
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect the user after logout (you can redirect to login or homepage)
        return redirect()->route('pdrrmo-home.index');
    }
}
