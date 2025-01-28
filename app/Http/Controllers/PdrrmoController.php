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

    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('banner_image')) {
            // Store the new banner image
            $path = $request->file('banner_image')->store('public/banner');
            
            // Optionally delete the old banner image
            // Storage::delete('public/banner/banner.png');
        }

        return redirect()->back()->with('success', 'Banner image updated!');
    }

    public function updateCarousel(Request $request)
    {
        $request->validate([
            'carousel_image_1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'carousel_image_2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'carousel_image_3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile('carousel_image_' . $i)) {
                // Store each carousel image
                $path = $request->file('carousel_image_' . $i)->store('public/carousel');
                
                // Optionally delete the old carousel images
                // Storage::delete("public/carousel/hero-carousel-{$i}.jpg");
            }
        }

        return redirect()->back()->with('success', 'Carousel images updated!');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
