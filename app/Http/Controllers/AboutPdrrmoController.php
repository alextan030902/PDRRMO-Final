<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutPDRRMO;

class AboutPDRRMOController extends Controller
{
    public function index()
    {
        return view('about-pdrrmo.index', [
            'about' => AboutPDRRMO::where('section', 'about')->first(),
            'mandate' => AboutPDRRMO::where('section', 'mandate')->first(),
            'vision' => AboutPDRRMO::where('section', 'vision')->first(),
            'mission' => AboutPDRRMO::where('section', 'mission')->first(),
            'functions' => AboutPDRRMO::where('section', 'functions')->first(),
        ]);
    }

    public function update(Request $request, $section)
    {
        AboutPDRRMO::updateOrCreate(
            ['section' => $section],
            ['content' => $request->content]
        );

        return redirect()->back()->with('success', ucfirst($section) . ' updated successfully!');
    }
}
