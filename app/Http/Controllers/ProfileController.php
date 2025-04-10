<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();

        return view('authentication.profile', compact('contactInfo'));
    }

    public function show()
    {
        $user = auth()->user();
        $contactInfo = ContactInfo::first();

        return view('authentication.profile', compact('user', 'contactInfo'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::id(),
        ]);

        $user = Auth::user();

        if ($user->name == $request->name && $user->email == $request->email) {
            return redirect()->route('authentication.profile')->with('info', 'No changes made.');
        }

        $oldData = $user->only(['name', 'email']);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        $changes = array_diff($user->only(['name', 'email']), $oldData);

        if (! empty($changes)) {
            event(new ActivityLogged(
                $user->name,
                'Updated profile',
                'User',
                $user->id,
                $changes
            ));
        }

        return redirect()->route('authentication.profile')->with('success', 'Profile successfully updated!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        if (! Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Log the password change event
        event(new ActivityLogged(
            $user->name,
            'Updated password',
            'User',
            $user->id,
            ['password' => 'updated']
        ));

        return redirect()->route('authentication.profile')->with('success', 'Password successfully updated!');
    }
}
