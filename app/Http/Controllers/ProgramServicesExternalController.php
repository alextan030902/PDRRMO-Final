<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\ContactInfo;
use App\Models\ExternalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramServicesExternalController extends Controller
{
    public function index()
    {
        $files = ExternalFile::all();
        $contactInfo = ContactInfo::first();

        return view('programs-services.external-services.index', compact('files', 'contactInfo'));
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
                $externalFile = ExternalFile::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_path' => $filePath,
                ]);

                event(new ActivityLogged(
                    auth()->user()->name,
                    'Uploaded a new file: '.$request->title,
                    'ExternalFile',
                    $externalFile->id,
                    ['file_path' => $filePath]
                ));

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
        $oldFilePath = $file->file_path;

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

        event(new ActivityLogged(
            auth()->user()->name,
            'Updated file: '.$request->title,
            'ExternalFile',
            $file->id,
            ['old_file_path' => $oldFilePath, 'new_file_path' => $file->file_path]
        ));

        return redirect()->route('programs-services.external-services.index')->with('success', 'File updated successfully');
    }

    public function destroy($id)
    {
        $file = ExternalFile::findOrFail($id);
        $filePath = $file->file_path;

        event(new ActivityLogged(
            auth()->user()->name,
            'Deleted file: '.$file->title,
            'ExternalFile',
            $file->id,
            ['file_path' => $filePath]
        ));

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $file->delete();

        return redirect()->route('programs-services.external-services.index')->with('success', 'File deleted successfully');
    }
}
