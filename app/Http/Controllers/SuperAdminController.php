<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function authenticate(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('super-admin.dashboard');
        } else {
            return redirect()->back()->withErrors(['Invalid credentials']);
        }
    }
}
