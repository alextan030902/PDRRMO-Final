<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;

class CarouselImageController extends Controller
{
    public function index()
    {
        // Fetch the first carousel image (or adjust the query to fit your requirements)
        $carouselImage = CarouselImage::first(); // or `CarouselImage::latest()->first();`

        // Pass the carousel image to the view
        return view('pdrrmo-home.index', compact('carouselImage'));
    }

    // Store or update carousel images
    public function store(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'carousel_images' => 'required|array',
            'carousel_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:50000', // Ensure each image is valid
        ]);

        // Check if carousel_images are provided
        if ($request->hasFile('carousel_images')) {
            // Loop through each uploaded image
            $imagePaths = [];
            foreach ($request->file('carousel_images') as $index => $image) {
                // Store each image in the 'carousel_images' directory
                $imagePaths[] = $image->store('carousel_images', 'public');
            }

            // Assuming there is a CarouselImage record already, or create a new one
            $carouselImage = CarouselImage::first() ?: new CarouselImage;

            // Save the image paths to the database (you may want to adjust this to handle dynamic columns)
            // Save images in a serialized array or database structure depending on your requirements
            $carouselImage->image_paths = json_encode($imagePaths);  // Save paths as a JSON array
            $carouselImage->save();
        }

        return redirect()->route('pdrrmo-home.index')->with('success', 'Images uploaded successfully!');
    }
}
