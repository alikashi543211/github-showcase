<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

abstract class Controller
{
    /** Resizes and saves both the large and thumbnail images. */
    protected function resizeAndSaveImage($file, $folderName, $originalFileName, $width = 430, $height = 270)
    {
        $folderPath = public_path($folderName);
        $filename = date('H-i') . '_' . $originalFileName;
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
        $categoryImagePath = $folderPath . '/' . $filename;
        // dd($folderPath, $categoryImagePath);
        Image::make($file)->save($categoryImagePath, 100); // Compress image

        return $folderName . '/' . $filename;
    }

    public function uploadDocument($file, $destinationPath)
    {
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $fullPath = public_path($destinationPath);

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // Only move the file (no resizing)
        $file->move($fullPath, $fileName);

        return $destinationPath . '/' . $fileName;
    }

    public function uploadTheFile($file, $destinationPath)
    {
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $fullPath = public_path($destinationPath);

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // Only move the file (no resizing)
        $file->move($fullPath, $fileName);

        return $destinationPath . '/' . $fileName;
    }

    protected function resizeAndSaveImageWithResize($file, $folderName, $originalFileName, $width = 430, $height = 270)
    {
        $folderPath = public_path($folderName);
        $filename = date('H-i') . '_' . $originalFileName;
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }
        $categoryImagePath = $folderPath . '/' . $filename;
        // dd($folderPath, $categoryImagePath);
        Image::make($file)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($categoryImagePath, 80); // Compress image

        return $folderName . '/' . $filename;
    }
}
