<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CarouselImage;
use App\Models\File;
use App\Models\Pdrrmo;
use App\Models\Videos;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class PdrrmoController extends Controller
{
    /**
     * Display the listing of the resource.
     */
    public function index()
    {
        $contactInfo = ContactInfo::first(); // Assuming there's only one entry
        // Fetch all activities with images
        $activities = Activity::with('images')->get();

        // Fetch the first carousel image, if it exists
        $carouselImage = CarouselImage::first();

        // If no carousel image exists, set image_paths to an empty array
        if ($carouselImage && $carouselImage->image_paths) {
            $carouselImage->image_paths = json_decode($carouselImage->image_paths, true);
        } else {
            $carouselImage = (object) ['image_paths' => []];
        }
        $videos = Videos::all();


        // Get the latest Pdrrmo record
        $pdrrmo = Pdrrmo::latest()->first();

        // Get the image path for Pdrrmo, if it exists
        $pdrrmoImagePath = $pdrrmo && $pdrrmo->image_path ? $pdrrmo->image_path : null;

        // Fetch all files (you may need this depending on your use case)
        $files = File::all();

        // Return the view with all the necessary data
        return view('pdrrmo-home.index', compact(
            'activities',
            'carouselImage',
            'pdrrmo',
            'contactInfo',
            'pdrrmoImagePath',
            'videos',
            'files'
        ));
    }


    /**
     * Show the form for uploading a new image.
     */
    public function upload(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000', // 50 MB
            ]);

            // Store the uploaded image
            $path = $request->file('image')->store('images', 'public');

            // Store the image path in the database
            Pdrrmo::create(['image_path' => $path]);

            // Use session to pass success message
            $request->session()->flash('success', 'Image uploaded successfully!');

            return redirect()->route('pdrrmo-home.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors (e.g., file size exceeded)
            $errorMessage = $e->errors() ? implode(', ', $e->errors()['image']) : 'Validation failed.';

            // Use session to pass error message
            $request->session()->flash('error', $errorMessage);

            return redirect()->route('pdrrmo-home.index');
        } catch (\Exception $e) {
            // Catch general exceptions
            $request->session()->flash('error', 'An unexpected error occurred: '.$e->getMessage());

            return redirect()->route('pdrrmo-home.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch resource for editing
        $pdrrmo = Pdrrmo::findOrFail($id);

        // Use session to pass success message
        session()->flash('success', 'Edit form loaded successfully!');

        return view('pdrrmo-home.edit', compact('pdrrmo'));  // Pass to the edit view
    }

    /**
     * Handle updating the pdrrmo-home data.
     */
    public function update(Request $request, $id)
    {
        // Find the resource by ID
        $pdrrmo = Pdrrmo::findOrFail($id);

        // Validate the uploaded image (if an image is being updated)
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            ]);

            // Store the new image and update the image_path
            $path = $request->file('image')->store('images', 'public');
            $pdrrmo->image_path = $path;
        }

        // Save other changes (if any)
        $pdrrmo->save();

        // Use session to pass success message
        $request->session()->flash('success', 'Image updated successfully!');

        // Redirect back to the edit view
        return redirect()->route('pdrrmo-home.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the resource exists
        $pdrrmo = Pdrrmo::find($id); // Use find() instead of findOrFail()

        if (! $pdrrmo) {
            // Use session to pass error message if the resource is not found
            session()->flash('error', 'Image not found!');

            return redirect()->route('pdrrmo-home.index')->with('error', 'Image not found!');
        }

        // Proceed with deleting if found
        $pdrrmo->delete();

        // Use session to pass success message
        session()->flash('success', 'Image deleted successfully!');

        return redirect()->route('pdrrmo-home.index')->with('success', 'Image deleted successfully!');
    }
}
