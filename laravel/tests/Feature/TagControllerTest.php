<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test it lists all tags.
     * This method tests if the API endpoint can successfully list all tags.
     */
    public function it_lists_all_tags()
    {
        $tags = Tag::factory()->count(5)->create();

        $response = $this->getJson('/api/tags');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                ],
            ],
        ]);
    }

    /**
     * Test it creates a tag.
     * This method tests if the API endpoint can successfully create a new tag.
     */
    public function it_creates_a_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $tagData = [
            'title' => 'New Tag',
        ];

        $response = $this->postJson('/api/tags', $tagData);

        $response->assertCreated();
        $this->assertDatabaseHas('tags', ['title' => 'New Tag']);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
            ],
        ]);
    }

    /**
     * Test it shows a tag.
     * This method tests if the API endpoint can successfully retrieve a single tag by ID.
     */
    public function it_shows_a_tag()
    {
        $tag = Tag::factory()->create();

        $response = $this->getJson("/api/tags/{$tag->id}");

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'title' => $tag->title,
            ]
        ]);
    }

    /**
     * Test it updates a tag.
     * This method tests if the API endpoint can successfully update an existing tag.
     */
    public function it_updates_a_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $tag = Tag::factory()->create();

        $updatedData = [
            'title' => 'Updated Tag Title',
        ];

        $response = $this->putJson("/api/tags/{$tag->id}", $updatedData);
        $response->assertOk();

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'title' => 'Updated Tag Title',
        ]);

        $response->assertJson([
            'data' => [
                'id' => $tag->id,
                'title' => 'Updated Tag Title',
            ]
        ]);
    }

    /**
     * Test it soft deletes a tag.
     * This method tests if the API endpoint can successfully soft delete a tag, making it inaccessible from normal queries.
     */
    public function it_soft_deletes_a_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $tag = Tag::factory()->create();

        $response = $this->deleteJson("/api/tags/{$tag->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted('tags', ['id' => $tag->id]);
    }
}
