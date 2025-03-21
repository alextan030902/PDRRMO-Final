<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityImage;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivitiesController extends Controller
{
    // Store a new activity with multiple images
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each file
        ]);

        // Create the activity record
        $activity = Activity::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Store images and link them to the activity
        foreach ($request->file('images') as $image) {
            // Store the image in the 'activity_images' folder within the 'public' disk
            $imagePath = $image->store('activity_images', 'public');

            // Create a new ActivityImage record for each image
            ActivityImage::create([
                'activity_id' => $activity->id, // Link the image to the activity
                'image_path' => $imagePath, // Store the image path
            ]);
        }

        // Redirect or return a response (you can customize this)
        return redirect()->route('pdrrmo-home.index')->with('success', 'Activity and images uploaded successfully!');
    }

    // Show a specific activity with its images
    public function show($id)
    {
        // Fetch the activity and its images
        $contactInfo = ContactInfo::first();
        $activity = Activity::with('images')->findOrFail($id);

        // Pass the data to the view
        return view('pdrrmo-home.edit', compact('activity', 'contactInfo'));
    }

    public function deleteImages(Request $request)
    {
        // Validate that the IDs are an array
        $validated = $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:activity_images,id', // Ensure that each ID exists in the database
        ]);

        // Delete each image by ID
        foreach ($validated['image_ids'] as $imageId) {
            $image = ActivityImage::find($imageId); // Use ActivityImage model instead of Activity
            if ($image) {
                // Delete the image file from storage
                Storage::delete('public/'.$image->image_path); // Make sure to adjust the path if needed
                $image->delete(); // Remove the image record from the database
            }
        }

        return redirect()->route('pdrrmo-home.index')->with('success', 'Image deleted successfully!');

    }
}
