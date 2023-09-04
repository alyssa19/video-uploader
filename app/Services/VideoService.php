<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class VideoService
{
    public function uploadVideoChunk($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = 'uploads/' . $fileName;

        Storage::put($path, file_get_contents($file->getRealPath()));

        return ['file_path' => $path];
    }
}
