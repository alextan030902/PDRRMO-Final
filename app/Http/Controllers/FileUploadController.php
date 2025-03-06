<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function index(Request $request)
    {
        // Fetch distinct years from the 'files' table
        $years = DB::table('files')
            ->select(DB::raw('EXTRACT(YEAR FROM date) as year'))
            ->distinct()
            ->pluck('year');
    
        // Get the selected year from the request
        $selectedYear = $request->input('year');
        
        // Fetch all categories with optional year filter
        $executiveOrders = File::where('category', 'Executive Order')
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->whereYear('date', $selectedYear);
            })
            ->get();
    
        $memos = File::where('category', 'Memo')
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->whereYear('date', $selectedYear);
            })
            ->get();
    
        $resolutions = File::where('category', 'Resolution')
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->whereYear('date', $selectedYear);
            })
            ->get();
    
        $advisories = File::where('category', 'Advisory')
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->whereYear('date', $selectedYear);
            })
            ->get();
        
        // Fetch contact info
        $contactInfo = ContactInfo::first();
    
        // For AJAX requests, return filtered data as JSON
        if ($request->ajax()) {
            return response()->json([
                'memos' => $memos,
                'executiveOrders' => $executiveOrders,
                'resolutions' => $resolutions,
                'advisories' => $advisories,
            ]);
        }
    
        // For regular page load, return the view with data
        return view('pdrrmo-home.issuances', compact(
            'memos',
            'executiveOrders',
            'resolutions',
            'advisories',
            'years',
            'contactInfo',
            'selectedYear' // Pass the selected year to the view
        ));
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

        // Return success message
        return redirect()->route('pdrrmo-home.issuances')->with('success', 'File deleted successfully.');
    }
}


