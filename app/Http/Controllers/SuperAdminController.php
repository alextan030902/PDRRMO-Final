<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function authenticate(Request $request)
    {
        // Logic to authenticate the super admin

        // For example, you can use Auth::attempt() to check credentials
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('super-admin.dashboard');
        } else {
            return redirect()->back()->withErrors(['Invalid credentials']);
        }
    }
}
