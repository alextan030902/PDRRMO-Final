<?php

namespace App\Http\Controllers;

use App\Models\InternalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramServicesInternalController extends Controller
{
    public function index()
    {
        $files = InternalFile::all();

        return view('programs-services.internal-services.index', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048', // Adjust as needed
        ]);

        try {
            // Store the file and get its path
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                // Store the file and get its path
                $filePath = $request->file('file')->store('uploads', 'public'); // Store in 'public/uploads' directory

                // Save the file record in the database
                InternalFile::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_path' => $filePath,
                ]);

                return redirect()->back()->with('success', 'File uploaded successfully');
            } else {
                return redirect()->back()->with('error', 'No valid file uploaded');
            }
        } catch (\Exception $e) {
            // Capture any errors and return a message
            return redirect()->back()->with('error', 'Error occurred while uploading: '.$e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
        ]);

        $file = InternalFile::findOrFail($id);
        $file->title = $request->title;
        $file->description = $request->description;

        // Check if a new file is uploaded
        if ($request->hasFile('file')) {
            // Delete the old file from storage
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }
            // Store the new file and update the file_path
            $filePath = $request->file('file')->store('uploads', 'public');
            $file->file_path = $filePath;
        }

        $file->save();

        return redirect()->route('programs-services.internal-services.index', $file->id)->with('success', 'File updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $file = InternalFile::findOrFail($id);

        // Delete the file from storage
        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        // Delete the record from the database
        $file->delete();

        return redirect()->route('programs-services.internal-services.index')->with('success', 'File deleted successfully');
    }
}
