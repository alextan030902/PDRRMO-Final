<?php

namespace App\Http\Controllers;

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
        AboutPdrrmc::updateOrCreate(
            ['section' => $section],
            ['content' => $request->content]
        );

        return redirect()->back()->with('success', ucfirst($section).' Updated successfully!');
    }
}
