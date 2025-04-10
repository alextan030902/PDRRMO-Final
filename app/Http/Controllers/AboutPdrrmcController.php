<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\AboutPdrrmc;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class AboutPdrrmcController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();
        $about = AboutPdrrmc::where('section', 'about')->first();
        $mandate = AboutPdrrmc::where('section', 'mandate')->first();
        $vision = AboutPdrrmc::where('section', 'vision')->first();
        $mission = AboutPdrrmc::where('section', 'mission')->first();
        $functions = AboutPdrrmc::where('section', 'functions')->first();

        return view('about-pdrrmc.index', compact('contactInfo', 'about', 'mandate', 'vision', 'mission', 'functions'));
    }

    public function update(Request $request, $section)
    {
        // Capture the existing content before updating (if it exists)
        $existingContent = AboutPdrrmc::where('section', $section)->first();

        // Perform the update or create the section if it doesn't exist
        $updatedSection = AboutPdrrmc::updateOrCreate(
            ['section' => $section],
            ['content' => $request->content]
        );

        // Check if the content was actually updated (if it's different from the previous one)
        if ($existingContent && $existingContent->content !== $request->content) {
            // Log the activity of updating the section
            event(new ActivityLogged(
                auth()->user()->name,                    // User who performed the action
                ucfirst($section).' section updated',  // Action description
                'AboutPdrrmc',                           // Entity type
                $updatedSection->id,                     // Entity ID
                ['content' => 'updated']                 // Changes made
            ));
        }

        return redirect()->back()->with('success', ucfirst($section).' Updated successfully!');
    }
}
