<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\Videos;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url',
        ]);

        $headers = get_headers($request->video_url);
        if (strpos($headers[0], '200') === false) {
            return redirect()->back()->with('error', 'Video URL is not available');
        }

        $video = new Videos;
        $video->video_url = $request->video_url;
        $video->save();

        event(new ActivityLogged(
            auth()->user()->name,
            'Uploaded a new video: '.$request->video_url,
            'Video',
            $video->id,
            ['video_url' => $request->video_url]
        ));

        return redirect()->route('pdrrmo-home.index')->with('success', 'Link uploaded successfully!');
    }

    public function destroy($id)
    {
        $video = Videos::findOrFail($id);

        event(new ActivityLogged(
            auth()->user()->name,
            'Deleted video: '.$video->video_url,
            'Video',
            $video->id,
            ['video_url' => $video->video_url]
        ));

        $video->delete();

        return redirect()->route('pdrrmo-home.index')->with('success', 'Video deleted successfully!');
    }
}
