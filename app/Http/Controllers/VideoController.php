<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url',
        ]);

        $video = new Videos;
        $video->video_url = $request->video_url;
        $video->save();

        return redirect()->route('pdrrmo-home.index')->with('success', 'Link uploaded successfully!');
    }
}
