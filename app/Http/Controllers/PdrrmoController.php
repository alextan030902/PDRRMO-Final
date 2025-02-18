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
        $activities = Activity::with('images')->get();

<<<<<<< HEAD
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
=======
        $carouselImage = CarouselImage::first();

        if ($carouselImage && $carouselImage->image_paths) {
            $carouselImage->image_paths = json_decode($carouselImage->image_paths, true);
        }

        $pdrrmo = Pdrrmo::latest()->first();

        $pdrrmoImagePath = $pdrrmo && $pdrrmo->image_path ? $pdrrmo->image_path : null;

        $files = File::all();

        return view('pdrrmo-home.index', compact(
            'activities',
            'carouselImage',
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
>>>>>>> f2ebacf4ea37a7b81a751f80ee0312768b0af3d3
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
<<<<<<< HEAD
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
=======
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
>>>>>>> f2ebacf4ea37a7b81a751f80ee0312768b0af3d3
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
