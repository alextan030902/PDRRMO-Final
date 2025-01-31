<?php

namespace App\Http\Controllers;

use App\Models\HeroCarousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroCarouselController extends Controller {
    
    public function index() {
        $carousels = HeroCarousel::all();
        return view('admin.hero-carousel.index', compact('carousels'));
    }

    public function store(Request $request) {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);

        $path = $request->file('image')->store('hero-carousel', 'public');

        HeroCarousel::create(['image_path' => $path]);

        return redirect()->back()->with('success', 'Image uploaded successfully.');
    }

    public function destroy(HeroCarousel $carousel) {
        Storage::disk('public')->delete($carousel->image_path);
        $carousel->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}

