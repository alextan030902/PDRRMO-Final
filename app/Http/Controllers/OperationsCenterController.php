<?php

namespace App\Http\Controllers;

use App\Models\OperationsCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OperationsCenterController extends Controller
{
    public function index()
    {
        $items = OperationsCenter::all();

        return view('operations-center.index', compact('items'));
    }

    public function create()
    {
        return view('operation-center.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:vehicle,equipment',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $item = OperationsCenter::create([
            'name' => $request->name,
            'image' => $imagePath,
            'type' => $request->type, // Save the type
        ]);

        return response()->json(['success' => 'Item added successfully', 'item' => $item]);
    }

    public function edit(OperationsCenter $operationCenter)
    {
        return view('operation-center.edit', compact('operationCenter'));
    }

    public function update(Request $request, OperationsCenter $operationCenter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:vehicle,equipment', // Validate the type
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($operationCenter->image);
            $imagePath = $request->file('image')->store('images', 'public');
            $operationCenter->image = $imagePath;
        }

        $operationCenter->name = $request->name;
        $operationCenter->type = $request->type; // Update the type
        $operationCenter->save();

        return response()->json(['success' => 'Item updated successfully', 'item' => $operationCenter]);
    }

    public function destroy(OperationsCenter $operationCenter)
    {
        Storage::disk('public')->delete($operationCenter->image);
        $operationCenter->delete();

        return redirect()->route('operations-center.index')->with('success', 'Item deleted successfully.');
    }
}
