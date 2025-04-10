<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\Activity;
use App\Models\CarouselImage;
use App\Models\ContactInfo;
use App\Models\File;
use App\Models\Pdrrmo;
use App\Models\Videos;
use Illuminate\Http\Request;

class PdrrmoController extends Controller
{
    /**
     * Display the listing of the resource.
     */
    public function index()
    {
        $contactInfo = ContactInfo::first();
        $activities = Activity::with('images')->get();

        $carouselImage = CarouselImage::first();

        if ($carouselImage && $carouselImage->image_paths) {
            $carouselImage->image_paths = json_decode($carouselImage->image_paths, true);
        } else {
            $carouselImage = (object) ['image_paths' => []];
        }
        $videos = Videos::all();

        $pdrrmo = Pdrrmo::latest()->first();

        $pdrrmoImagePath = $pdrrmo && $pdrrmo->image_path ? $pdrrmo->image_path : null;

        $files = File::all();

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
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);

            $path = $request->file('image')->store('images', 'public');

            $pdrrmo = Pdrrmo::create(['image_path' => $path]);

            event(new ActivityLogged(
                auth()->user()->name,
                'Uploaded a new image for PDRRMO',
                'Pdrrmo',
                $pdrrmo->id,
                ['image_path' => $path]
            ));

            $request->session()->flash('success', 'Image uploaded successfully!');

            return redirect()->route('pdrrmo-home.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessage = $e->errors() ? implode(', ', $e->errors()['image']) : 'Validation failed.';

            $request->session()->flash('error', $errorMessage);

            return redirect()->route('pdrrmo-home.index');
        } catch (\Exception $e) {
            $request->session()->flash('error', 'An unexpected error occurred: '.$e->getMessage());

            return redirect()->route('pdrrmo-home.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pdrrmo = Pdrrmo::findOrFail($id);

        session()->flash('success', 'Edit form loaded successfully!');

        return view('pdrrmo-home.edit', compact('pdrrmo'));
    }

    /**
     * Handle updating the pdrrmo-home data.
     */
    public function update(Request $request, $id)
    {
        $pdrrmo = Pdrrmo::findOrFail($id);

        // Store the original image path before updating
        $oldImagePath = $pdrrmo->image_path;

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:102400',
            ]);

            $path = $request->file('image')->store('images', 'public');
            $pdrrmo->image_path = $path;
        }

        $pdrrmo->save();

        // Log the activity for image update
        event(new ActivityLogged(
            auth()->user()->name,
            'Updated image for PDRRMO (changed from '.$oldImagePath.' to '.$pdrrmo->image_path.')',
            'Pdrrmo',
            $pdrrmo->id,
            ['old_image_path' => $oldImagePath, 'new_image_path' => $pdrrmo->image_path]
        ));

        $request->session()->flash('success', 'Image updated successfully!');

        return redirect()->route('pdrrmo-home.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pdrrmo = Pdrrmo::find($id);

        if (! $pdrrmo) {
            return redirect()->route('pdrrmo-home.index')->with('error', 'Image not found!');
        }

        event(new ActivityLogged(
            auth()->user()->name,
            'Deleted image for PDRRMO with ID: '.$id,
            'Pdrrmo',
            $pdrrmo->id,
            ['image_path' => $pdrrmo->image_path]
        ));

        $pdrrmo->delete();

        return redirect()->route('pdrrmo-home.index')->with('success', 'Image deleted successfully!');
    }
}
