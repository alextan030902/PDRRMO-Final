<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\UsefulLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UsefulLinkController extends Controller
{
    public function index()
    {
        $links = UsefulLink::all();

        return view('useful-links.index', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'link' => 'required|url',
        ]);

        $image = $request->file('image');
        $path = $image->store('links', 'public');
        $imageUrl = 'storage/'.$path;

        $usefulLink = UsefulLink::create([
            'image' => $imageUrl,
            'link' => $request->link,
        ]);

        if ($usefulLink && $usefulLink->id) {
            event(new ActivityLogged(
                Auth::user()->name,
                'Added a new useful link: '.$request->link,
                'Useful Link',
                $usefulLink->id,
                [
                    'link' => $request->link,
                    'image' => $imageUrl,
                ]
            ));
        }

        return back()->with('success', 'Link added successfully.');
    }

    public function destroy($id)
    {
        $link = UsefulLink::findOrFail($id);

        event(new ActivityLogged(
            Auth::user()->name,
            'Deleted a useful link: '.$link->link,
            'Useful Link',
            $link->id,
            [
                'link' => $link->link,
                'image' => $link->image,
            ]
        ));

        Storage::delete('public/'.str_replace('storage/', '', $link->image));

        $link->delete();

        return back()->with('success', 'Link deleted successfully.');
    }
}
