<?php

namespace App\Http\Controllers;

use App\Models\ExternalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramServicesExternalController extends Controller
{
    public function index()
    {
        $files = ExternalFile::all();

        return view('programs-services.external-services.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:2048',
        ], [
            'file.required' => 'Please upload a file.',
            'file.mimes' => 'Only PDF, DOC, DOCX, JPG, PNG, and JPEG files are allowed.',
            'file.max' => 'The file size should not exceed 2MB.',
        ]);

        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $filePath = $request->file('file')->store('uploads', 'public');
                ExternalFile::create([
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

        $file = ExternalFile::findOrFail($id);
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

        return redirect()->route('programs-services.external-services.index')->with('success', 'File updated successfully');
    }

    public function destroy($id)
    {
        $file = ExternalFile::findOrFail($id);

        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        $file->delete();

        return redirect()->route('programs-services.external-services.index')->with('success', 'File deleted successfully');
    }
}
