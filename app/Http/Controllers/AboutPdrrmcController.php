<?php

namespace App\Http\Controllers;

use App\Models\AboutPdrrmc;
use Illuminate\Http\Request;

class AboutPdrrmcController extends Controller
{
    public function index()
    {
        return view('about-pdrrmc.index', [
            'about' => AboutPdrrmc::where('section', 'about')->first(),
            'mandate' => AboutPdrrmc::where('section', 'mandate')->first(),
            'vision' => AboutPdrrmc::where('section', 'vision')->first(),
            'mission' => AboutPdrrmc::where('section', 'mission')->first(),
            'functions' => AboutPdrrmc::where('section', 'functions')->first(),
        ]);
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
