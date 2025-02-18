<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdrrmoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pdrrmo-home.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Method to update the banner image
    public function updateBanner(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if a new banner image was uploaded
        if ($request->hasFile('banner_image')) {
            // Store the new banner image
            $path = $request->file('banner_image')->store('public/banners');

            // Save the path to the database (optional, depending on your app)
            // Banner::update(['image_path' => $path]);

            // Optionally, delete the old image from storage
            // Storage::delete($oldBannerImagePath);
        }

        return back()->with('success', 'Banner image updated successfully!');
    }

    // Method to update the carousel images
    public function updateCarousel(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'carousel_image_1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'carousel_image_2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'carousel_image_3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Loop through each carousel image and store if uploaded
        for ($i = 1; $i <= 3; $i++) {
            $carouselImage = 'carousel_image_'.$i;
            if ($request->hasFile($carouselImage)) {
                // Store the carousel image
                $path = $request->file($carouselImage)->store('public/carousels');

                // Save the path to the database (optional, depending on your app)
                // Carousel::updateOrCreate(['image' => $path]);

                // Optionally, delete the old images from storage if you store paths in DB
                // Storage::delete($oldCarouselImagePath);
            }
        }

        return back()->with('success', 'Carousel images updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
