<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MultipleFileUploadController extends Controller
{
    public function getFileUploadForm()
    {
        return view('multiple-file-upload');
    }

    public function store(Request $request)
    {

        $request->validate([
            'documents' => 'required',
            'documents.*' => 'required|mimes:doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg|max:2048',
        ]);

        $deleteFile = $request->input('hiddenFile') ?? [];
        if (is_string($deleteFile)) {
            $deleteFile = array_map('trim', explode(',', $deleteFile));
        }

         // Process and store only the filtered files
        foreach ($request->file('documents') as $file) {
            $fileName = $file->getClientOriginalName();
            // Check if the file name is in the delete list or already processed
            if (!in_array($fileName, $deleteFile)) {
                // Store the file
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                // Save file details to the database
                File::create([
                    'name' => $fileName,
                    'path' => Storage::url($filePath),
                ]);
            }
        }
        return back()->with('success', 'Files have been successfully uploaded.');
    }

}
