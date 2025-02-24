<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    // Store the video URL
    public function store(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url',  // Validate the URL
        ]);

        // Save the video URL to the database
        $video = new Videos;
        $video->video_url = $request->video_url;
        $video->save();

        return redirect()->route('pdrrmo-home.index')->with('success', 'Link uploaded successfully!');
    }
}
