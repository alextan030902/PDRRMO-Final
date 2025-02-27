<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;

class TeamsController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();

        return view('super-admin.team', compact('contactInfo'));
    }
}
