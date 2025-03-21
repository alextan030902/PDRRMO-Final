<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
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
        $contactInfo = ContactInfo::first();
        $rescueOperation = RescueOperation::latest()->first();

        $categories = RescueOperation::select('category')->distinct()->get();

        $rescueOperations = RescueOperation::all();

        return view('programs-services.rescue-operations.index', compact('rescueOperation', 'categories', 'contactInfo', 'rescueOperations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Request received:', $request->all());

        $validated = $request->validate([
            'category' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Log::info('Validated data:', $validated);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('rescue_operations_images', 'public');
                $imagePaths[] = $imagePath;

                Log::info('Stored image path:', [$imagePath]);
            }
        }
        Log::info('Image paths:', $imagePaths);

        try {
            $rescueOperation = RescueOperation::create([
                'category' => $validated['category'],
                'description' => $validated['description'],
                'images' => $imagePaths,
            ]);

            Log::info('Rescue operation saved:', $rescueOperation->toArray());
        } catch (\Exception $e) {
            Log::error('Error saving rescue operation:', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'There was an issue saving the rescue operation.');
        }

        return redirect()->route('programs-services.rescue-operations.index')
            ->with('success', 'Rescue Operation added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($category)
    {
        $contactInfo = ContactInfo::first();
        $rescueOperations = RescueOperation::where('category', $category)->get();

        if ($rescueOperations->isEmpty()) {
            return redirect()->route('portfolio')->with('error', 'No Rescue Operations found for this category.');
        }

        return view('programs-services.rescue-operations.show', compact('rescueOperations', 'category', 'contactInfo'));
    }

    public function destroy(string $id)
    {
        // Check if the operation exists before attempting to delete
        $operation = RescueOperation::find($id);

        if (! $operation) {
            return redirect()->route('programs-services.rescue-operations.index')
                ->with('info', 'No available image.');
        }

        $operation->delete();

        return redirect()->route('programs-services.rescue-operations.index')
            ->with('success', 'Rescue operation deleted successfully.');
    }

    public function contentDestroy(string $id)
    {
        $operation = RescueOperation::findOrFail($id);

        $operation->delete();

        return redirect()->route('programs-services.rescue-operations.index')->with('success', 'Content deleted successfully.');
    }

    public function content(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $rescueOperation = new RescueOperation;
        $rescueOperation->content = $request->content;

        $rescueOperation->save();

        return redirect()->back()->with('success', 'Content added successfully!');
    }

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
