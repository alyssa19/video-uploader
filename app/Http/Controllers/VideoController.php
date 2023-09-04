<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VideoResource;
use App\Services\VideoService;

class VideoController extends Controller
{
    public function upload(Request $request, VideoService $videoService)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:mp4,mov,avi|max:10240', // Adjust max file size as needed
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $video = $videoService->uploadVideoChunk($request->file('file'));
    
        return new VideoResource($video);
    }
}
