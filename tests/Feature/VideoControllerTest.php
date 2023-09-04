<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoControllerTest extends TestCase
{
    use WithFaker;

    public function testUploadVideo()
    {
        Storage::fake('uploads');
        
        $file = UploadedFile::fake()->create('video.mp4', 1024 * 1024); 
        
        $response = $this->postJson('/api/upload-video', ['file' => $file]);

        $response->assertStatus(200)
                ->assertJsonStructure(['data' => ['file_path']]);

        Storage::disk('uploads')->assertExists($response->json('data.file_path'));
    }
}
