<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /**
     * Test it upload an image.
     * This method tests if the API endpoint can successfully upload an image and return the url.
     */
    public function it_uploads_an_image()
    {
        $response = $this->postJson('/api/upload', [
            'file' => UploadedFile::fake()->image('testimage.jpg')
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'location'
        ]);

        $location = $response->json('location');
        Storage::disk('public')->assertExists(parse_url($location, PHP_URL_PATH));
    }
}
