<?php

namespace App\Http\Controllers;

use App\Models\InternalFile;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramServicesInternalController extends Controller
{
    public function index()
    {
        $files = InternalFile::all();
        $contactInfo = ContactInfo::first();

        return view('programs-services.internal-services.index', compact('files','contactInfo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048', 
        ]);

        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $filePath = $request->file('file')->store('uploads', 'public'); 

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

        if ($request->hasFile('file')) {
            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }
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
