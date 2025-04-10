<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\ContactInfo;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve distinct categories
        $categories = File::distinct()->pluck('category');
        $contactInfo = ContactInfo::first();

        // Retrieve distinct years using EXTRACT for PostgreSQL
        $years = File::selectRaw('EXTRACT(YEAR FROM date) as year')
            ->distinct()
            ->pluck('year');

        // Get the selected filters from the request
        $selectedCategory = $request->input('category');
        $selectedYear = $request->input('year');

        // Filter the files based on the selected category and year
        $files = File::query()
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                return $query->where('category', $selectedCategory);
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->whereRaw('EXTRACT(YEAR FROM date) = ?', [$selectedYear]);
            })
            ->get();

        return view('pdrrmo-home.issuances', compact('files', 'categories', 'years', 'contactInfo'));
    }

    public function getYearsByCategory(Request $request)
    {
        // Get the selected category
        $selectedCategory = $request->input('category');

        // Fetch distinct years for the selected category
        $years = DB::table('files')
            ->select(DB::raw('EXTRACT(YEAR FROM date) as year'))
            ->distinct()
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                return $query->where('category', $selectedCategory);
            })
            ->orderBy(DB::raw('EXTRACT(YEAR FROM date)'), 'asc')
            ->pluck('year');

        // Return the years as JSON response
        return response()->json([
            'years' => $years,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'filename' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:10240',
            'date' => 'required|date',
        ]);

        $file = $request->file('file');
        $path = $file->store('issuances', 'public');

        $fileRecord = File::create([
            'name' => $request->filename,
            'path' => $path,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'category' => $request->category,
            'date' => $request->date,
        ]);

        // Log the activity of uploading a new file
        event(new ActivityLogged(
            auth()->user()->name,
            'Uploaded file: '.$request->filename,
            'File',
            $fileRecord->id,
            [
                'category' => $request->category,
                'filename' => $request->filename,
                'date' => $request->date,
            ]
        ));

        // Return a success response
        return back()->with('success', 'File uploaded successfully!');
    }

    public function destroy($id)
    {
        // Find the file record by ID
        $file = File::find($id);

        // Check if the file record exists
        if (! $file) {
            return redirect()->route('pdrrmo-home.issuances')->with('error', 'File not found in the database.');
        }

        // Check if the file exists in storage
        if (! Storage::disk('public')->exists($file->path)) {
            return redirect()->route('pdrrmo-home.issuances')->with('error', 'File not found in storage.');
        }

        try {
            // Try to delete the file from storage using the stored path
            Storage::disk('public')->delete($file->path);
        } catch (\Exception $e) {
            // In case of error deleting the file, handle gracefully
            return redirect()->route('pdrrmo-home.issuances')->with('error', 'Failed to delete the file from storage: '.$e->getMessage());
        }

        // After file deletion, delete the record from the database
        $file->delete();

        // Log the activity of deleting a file
        event(new ActivityLogged(
            auth()->user()->name,
            'Deleted file: '.$file->name,
            'File',
            $file->id,
            ['name' => $file->name, 'category' => $file->category]
        ));

        // Return success message
        return redirect()->route('pdrrmo-home.issuances')->with('success', 'File deleted successfully.');
    }
}
