<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\CarouselImage;
use App\Models\File;
use App\Models\Pdrrmo;
use Illuminate\Http\Request;

class PdrrmoController extends Controller
{
    /**
     * Display the listing of the resource.
     */
    public function index()
    {
        // Fetch all activities with their related images (eager loading)
        $activities = Activity::with('images')->get();

        // Fetch the latest CarouselImage record and all other carousel images
        $carousel = CarouselImage::latest()->first();
        $carouselImages = CarouselImage::all();

        // Get the image paths from the latest carousel record
        $carouselImage1 = $carousel ? $carousel->image_path_1 : null;
        $carouselImage2 = $carousel ? $carousel->image_path_2 : null;
        $carouselImage3 = $carousel ? $carousel->image_path_3 : null;

        // Fetch the latest Pdrrmo record and its image path
        $pdrrmo = Pdrrmo::latest()->first();
        $pdrrmoImagePath = $pdrrmo ? $pdrrmo->image_path : null;

        // Fetch all files (if needed)
        $files = File::all();

        // Pass all the variables to the view
        return view('pdrrmo-home.index', compact(
            'activities',
            'carouselImage1',
            'carouselImage2',
            'carouselImage3',
            'carouselImages',
            'pdrrmo',
            'pdrrmoImagePath',
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

    public function delete($imageIndex)
    {
        // Fetch the latest CarouselImage record
        $carousel = CarouselImage::latest()->first();

        // Handle deletion based on the image index
        switch ($imageIndex) {
            case 1:
                $carousel->image_path_1 = null;
                break;
            case 2:
                $carousel->image_path_2 = null;
                break;
            case 3:
                $carousel->image_path_3 = null;
                break;
        }

        // Save the changes to the database
        $carousel->save();

        // Use session to pass success message
        session()->flash('success', 'Carousel image deleted successfully');

        // Redirect back to the carousel index with a success message
        return redirect()->route('carousel.index')->with('success', 'Image deleted successfully');
    }
}
