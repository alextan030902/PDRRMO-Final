<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogged;
use App\Models\ContactInfo;
use App\Models\InternalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramServicesInternalController extends Controller
{
    public function index()
    {
        $files = InternalFile::all();
        $contactInfo = ContactInfo::first();

        return view('programs-services.internal-services.index', compact('files', 'contactInfo'));
    }

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

                $internalFile = InternalFile::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'file_path' => $filePath,
                ]);

                event(new ActivityLogged(
                    auth()->user()->name,
                    'Uploaded a new internal file: '.$request->title,
                    'InternalFile',
                    $internalFile->id,
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

        $file = InternalFile::findOrFail($id);
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
            'Updated internal file: '.$request->title,
            'InternalFile',
            $file->id,
            ['old_file_path' => $oldFilePath, 'new_file_path' => $file->file_path]
        ));

        return redirect()->route('programs-services.internal-services.index', $file->id)->with('success', 'File updated successfully');
    }

    public function destroy($id)
    {
        $file = InternalFile::findOrFail($id);
        $filePath = $file->file_path;

        event(new ActivityLogged(
            auth()->user()->name,
            'Deleted internal file: '.$file->title,
            'InternalFile',
            $file->id,
            ['file_path' => $filePath]
        ));

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        $file->delete();

        return redirect()->route('programs-services.internal-services.index')->with('success', 'File deleted successfully');
    }
}
