<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselImageController extends Controller
{
    public function index()
    {
        $carouselImage = CarouselImage::first();

        $imagePaths = $carouselImage ? json_decode($carouselImage->image_paths, true) : [];

        return view('pdrrmo-home.index', compact('carouselImage', 'imagePaths'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'carousel_images' => 'required|array',
            'carousel_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:50000',
        ]);

        if ($request->hasFile('carousel_images')) {
            $imagePaths = [];
            foreach ($request->file('carousel_images') as $index => $image) {
                $imagePaths[] = $image->store('carousel_images', 'public');
            }

            $carouselImage = CarouselImage::first() ?: new CarouselImage;

            $carouselImage->image_paths = json_encode($imagePaths);
            $carouselImage->save();
        }

        return redirect()->route('pdrrmo-home.index')->with('success', 'Images uploaded successfully!');
    }

    public function delete(Request $request)
    {
        $imagePathsToDelete = $request->input('image_paths');

        $carouselImage = CarouselImage::first();

        if ($carouselImage) {
            $currentImages = json_decode($carouselImage->image_paths, true);

            $updatedImages = array_diff($currentImages, $imagePathsToDelete);

            foreach ($imagePathsToDelete as $path) {
                if (Storage::exists('public/'.$path)) {
                    Storage::delete('public/'.$path);
                }
            }

            $carouselImage->image_paths = json_encode(array_values($updatedImages));
            $carouselImage->save();
        }

        return redirect()->route('pdrrmo-home.index')->with('success', 'Images deleted successfully!');
    }
}
