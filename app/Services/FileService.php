<?php
namespace App\Services;

use Illuminate\Support\Facades\Request;

class FileService {
    protected function uploadImages(Request $request)
    {
        if (! $request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $file->store('images_folder');

        return $file->hashName();
    }
}