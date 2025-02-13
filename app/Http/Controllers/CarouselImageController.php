<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage; // Correct model import
use Illuminate\Http\Request;

class CarouselImageController extends Controller
{
    // Display the carousel images

    // Store or update carousel images
    public function store(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'image_1' => 'required|image|mimes:jpeg,png,jpg,gif|max:50000',
            'image_2' => 'required|image|mimes:jpeg,png,jpg,gif|max:50000',
            'image_3' => 'required|image|mimes:jpeg,png,jpg,gif|max:50000',
        ]);

        // Upload the images
        $imagePath1 = $request->file('image_1')->store('carousel_images', 'public');
        $imagePath2 = $request->file('image_2')->store('carousel_images', 'public');
        $imagePath3 = $request->file('image_3')->store('carousel_images', 'public');

        // Assuming there is a CarouselImage record already, or create a new one
        $carouselImage = CarouselImage::first() ?: new CarouselImage;

        // Save the image paths to the database
        $carouselImage->image_path_1 = $imagePath1;
        $carouselImage->image_path_2 = $imagePath2;
        $carouselImage->image_path_3 = $imagePath3;
        $carouselImage->save();

        return redirect()->route('pdrrmo-home.index')->with('success', 'Images uploaded successfully!');
    }

    // Delete an image

}
