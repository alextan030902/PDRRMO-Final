<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\AboutPdrrmc;
use App\Models\ContactInfo;
use App\Models\OrgChart;
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
        $orgChart = OrgChart::latest()->first();
        $orgChartPath = $orgChart ? $orgChart->org_chart_image : null;

        return view('about-pdrrmc.index', compact('contactInfo', 'about', 'mandate', 'vision', 'mission', 'orgChartPath', 'functions'));
    }

    public function update(Request $request, $section)
    {
        $existingContent = AboutPdrrmc::where('section', $section)->first();

        $updatedSection = AboutPdrrmc::updateOrCreate(
            ['section' => $section],
            ['content' => $request->content]
        );

        if ($existingContent && $existingContent->content !== $request->content) {
            event(new ActivityLogged(
                auth()->user()->name,
                ucfirst($section).' section updated',
                'AboutPdrrmc',
                $updatedSection->id,
                ['content' => 'updated']
            ));
        }

        return redirect()->back()->with('success', ucfirst($section).' Updated successfully!');
    }

    public function updateOrgChart(Request $request)
    {
        $request->validate([
            'org_chart_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('org_chart_image')) {
            $file = $request->file('org_chart_image');
            $path = $file->store('org_chart_images', 'public');
            $imageUrl = 'storage/'.$path;

            $existingOrgChart = OrgChart::latest()->first();

            if ($existingOrgChart) {
                $existingOrgChart->org_chart_image = $imageUrl;
                $existingOrgChart->save();
            } else {
                OrgChart::create(['org_chart_image' => $imageUrl]);
            }

            event(new ActivityLogged(
                auth()->user()->name,
                'Updated the organizational chart image.',
                'Organizational Chart',
                $existingOrgChart ? $existingOrgChart->id : null,
                [
                    'image' => $imageUrl,
                ]
            ));

            return redirect()->back()->with('success', 'Organizational chart image updated successfully!');
        }

        return redirect()->back()->with('error', 'No image file was uploaded.');
    }
}
