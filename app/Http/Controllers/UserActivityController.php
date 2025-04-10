<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ContactInfo;

class UserActivityController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();

        $logs = ActivityLog::latest()->get();

        return view('authentication.activity-log', compact('logs', 'contactInfo'));
    }
}
