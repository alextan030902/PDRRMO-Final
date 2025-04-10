<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\Activity;
use App\Models\ActivityImage;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivitiesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $activity = Activity::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('activity_images', 'public');

            ActivityImage::create([
                'activity_id' => $activity->id,
                'image_path' => $imagePath,
            ]);
        }

        event(new ActivityLogged(
            auth()->user()->name,
            'New activity created with images',
            'Activity',
            $activity->id,
            ['title' => $activity->title, 'description' => $activity->description]
        ));

        return redirect()->route('pdrrmo-home.index')->with('success', 'Activity and images uploaded successfully!');
    }

    public function show($id)
    {
        $contactInfo = ContactInfo::first();
        $activity = Activity::with('images')->findOrFail($id);

        return view('pdrrmo-home.edit', compact('activity', 'contactInfo'));
    }

    public function deleteImages(Request $request)
    {
        $validated = $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:activity_images,id',
        ]);

        foreach ($validated['image_ids'] as $imageId) {
            $image = ActivityImage::find($imageId);
            if ($image) {
                Storage::delete('public/'.$image->image_path);
                $image->delete();
            }
        }

        event(new ActivityLogged(
            auth()->user()->name,
            'Images deleted from activity',
            'Activity',
            $image->activity_id,
            ['image_ids' => $validated['image_ids']]
        ));

        return redirect()->route('pdrrmo-home.index')->with('success', 'Image deleted successfully!');
    }
}
