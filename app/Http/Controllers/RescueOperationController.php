<?php

namespace App\Http\Controllers;

use App\Models\RescueOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RescueOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the latest rescue operation record
        $rescueOperation = RescueOperation::latest()->first();

        // Fetch distinct categories from the database
        $categories = RescueOperation::select('category')->distinct()->get();

        // Fetch all rescue operations
        $rescueOperations = RescueOperation::all();

        // Pass all data to the view
        return view('programs-services.rescue-operations.index', compact('rescueOperation', 'categories', 'rescueOperations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log the incoming request data (including the images)
        Log::info('Request received:', $request->all());

        // Validate the form data
        $validated = $request->validate([
            'category' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validation for images
        ]);

        // Log the validated data to make sure everything is correct
        Log::info('Validated data:', $validated);

        // Handle image upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image in the 'public' disk in 'rescue_operations_images' directory
                $imagePath = $image->store('rescue_operations_images', 'public');
                $imagePaths[] = $imagePath;

                // Log the stored image paths
                Log::info('Stored image path:', [$imagePath]);
            }
        }

        // Log the array of image paths
        Log::info('Image paths:', $imagePaths);

        try {
            // Save the rescue operation record to the database
            $rescueOperation = RescueOperation::create([
                'category' => $validated['category'],
                'description' => $validated['description'],
                'images' => $imagePaths,  // Store the images as an array (it will be auto-converted to JSON)
            ]);

            // Log the saved rescue operation record (converted to array)
            Log::info('Rescue operation saved:', $rescueOperation->toArray());
        } catch (\Exception $e) {
            // Log any exceptions during the database insert operation
            Log::error('Error saving rescue operation:', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'There was an issue saving the rescue operation.');
        }

        // Redirect with success message after the record is saved
        return redirect()->route('programs-services.rescue-operations.index')
            ->with('success', 'Rescue Operation added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($category)
    {
        // Retrieve all rescue operations based on the category
        $rescueOperations = RescueOperation::where('category', $category)->get();

        // Check if there are any rescue operations found
        if ($rescueOperations->isEmpty()) {
            // If no rescue operations are found, redirect back with an error message
            return redirect()->route('portfolio')->with('error', 'No Rescue Operations found for this category.');
        }

        // Pass the category and rescue operations to the view
        return view('programs-services.rescue-operations.show', compact('rescueOperations', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the rescue operation by ID
        $operation = RescueOperation::findOrFail($id);

        // Delete the operation
        $operation->delete();

        // Redirect back with a success message
        return redirect()->route('programs-services.rescue-operations.index')->with('success', 'Image deleted successfully.');
    }

    public function contentDestroy(string $id)
    {
        // Find the rescue operation by ID
        $operation = RescueOperation::findOrFail($id);

        // Delete the operation
        $operation->delete();

        // Redirect back with a success message
        return redirect()->route('programs-services.rescue-operations.index')->with('success', 'Image deleted successfully.');
    }


    public function content(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'content' => 'required|string|max:5000',  // Validate 'content'
        ]);

        // Create a new RescueOperation entry and set the 'content' column
        $rescueOperation = new RescueOperation;
        $rescueOperation->content = $request->content; // Save the content

        // Save to the database
        $rescueOperation->save();

        // Redirect or return a response with a success message
        return redirect()->back()->with('success', 'Content added successfully!');
    }

    // Handle the form submission and update the content
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:5000', 
        ]);

        $rescueOperation = RescueOperation::findOrFail($id);
        $rescueOperation->content = $request->content;
        $rescueOperation->save();

        return redirect()->route('programs-services.rescue-operations.index')->with('success', 'Content updated successfully!');
    }
}
