<?php

namespace App\Http\Controllers;

use App\Models\AboutPdrrmo;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class AboutPdrrmoController extends Controller
{
    public function index()
    {
        $contactInfo = ContactInfo::first();
        $about = AboutPdrrmo::where('section', 'about')->first();
        $mandate = AboutPdrrmo::where('section', 'mandate')->first();
        $vision = AboutPdrrmo::where('section', 'vision')->first();
        $mission = AboutPdrrmo::where('section', 'mission')->first();
        $functions = AboutPdrrmo::where('section', 'functions')->first();

        return view('about-pdrrmo.index', compact('contactInfo', 'about', 'mandate', 'vision', 'mission', 'functions'));
    }

    public function update(Request $request, $section)
    {
        AboutPdrrmo::updateOrCreate(
            ['section' => $section],
            ['content' => $request->content]
        );

        return redirect()->route('about-pdrrmo.index')->with('success', 'Content updated successfully!');
    }
}
