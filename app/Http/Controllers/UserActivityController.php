<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\ContactInfo;

class UserActivityController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::latest()
            ->distinct()
            ->get(['user_name', 'action', 'model', 'changes', 'created_at']);
    
        $contactInfo = ContactInfo::first();
    
        return view('authentication.activity-log', compact('logs', 'contactInfo'));
    }
    
}
