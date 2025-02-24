<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselImageController extends Controller
{
    public function index()
    {
        // Fetch the carousel image(s)
        $carouselImage = CarouselImage::first();

        // Check if the image_paths are already decoded, if not decode it
        $imagePaths = $carouselImage ? json_decode($carouselImage->image_paths, true) : [];

        // Pass the decoded image paths to the view
        return view('pdrrmo-home.index', compact('carouselImage', 'imagePaths'));
    }

    // Store or update carousel images
    public function store(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'carousel_images' => 'required|array',
            'carousel_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:50000',
        ]);

        // Check if carousel_images are provided
        if ($request->hasFile('carousel_images')) {
            $imagePaths = [];
            foreach ($request->file('carousel_images') as $index => $image) {
                $imagePaths[] = $image->store('carousel_images', 'public');
            }

            $carouselImage = CarouselImage::first() ?: new CarouselImage;

            $carouselImage->image_paths = json_encode($imagePaths);  // Save paths as a JSON array
            $carouselImage->save();
        }

        return redirect()->route('pdrrmo-home.index')->with('success', 'Images uploaded successfully!');
    }

    // Delete selected carousel images
    public function delete(Request $request)
    {
        $imagePathsToDelete = $request->input('image_paths'); // Array of selected image paths to delete

        // Fetch the current carousel images
        $carouselImage = CarouselImage::first();

        if ($carouselImage) {
            $currentImages = json_decode($carouselImage->image_paths, true);

            // Remove selected images from the list
            $updatedImages = array_diff($currentImages, $imagePathsToDelete);

            // Delete the files from the storage
            foreach ($imagePathsToDelete as $path) {
                if (Storage::exists('public/'.$path)) {
                    Storage::delete('public/'.$path);
                }
            }

            // Update the carousel images in the database
            $carouselImage->image_paths = json_encode(array_values($updatedImages));
            $carouselImage->save();
        }

        return redirect()->route('pdrrmo-home.index')->with('success', 'Images deleted successfully!');
    }
}
