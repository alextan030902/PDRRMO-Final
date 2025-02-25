<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file.*' => 'required|file|mimes:jpg,png,pdf,docx,txt|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $files = $request->file('file');
            $uploadedFiles = [];

            foreach ($files as $file) {
                $path = $file->store('uploads', 'public');

                $fileRecord = File::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                ]);

                $uploadedFiles[] = $fileRecord;
            }

            return redirect()->route('pdrrmo-home.index')->with('success', 'Files uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No files were uploaded.');
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }

        $file->delete();

        return redirect()->route('pdrrmo-home.index')->with('success', 'File deleted successfully');
    }
}
