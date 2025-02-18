<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request; // Make sure to import the File model
use Illuminate\Support\Facades\Storage; // For handling file storage

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'file.*' => 'required|file|mimes:jpg,png,pdf,docx,txt|max:2048', // Adjust validation as needed
        ]);

        // Check if files were uploaded
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            $uploadedFiles = [];

            // Loop through each file and store it
            foreach ($files as $file) {
                // Store each file in the 'uploads' directory (or another directory of your choice)
                $path = $file->store('uploads', 'public'); // Store in 'storage/app/public/uploads'

                // Create a new File record in the database
                $fileRecord = File::create([
                    'name' => $file->getClientOriginalName(), // Get the original file name
                    'path' => $path, // Store the path to the file
                ]);

                $uploadedFiles[] = $fileRecord; // Optionally keep track of the uploaded files
            }

            // Redirect or return success response with uploaded file paths
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
