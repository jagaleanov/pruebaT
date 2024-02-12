<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test it lists all categories.
     * This method tests if the API endpoint can successfully list all categories.
     */
    public function it_lists_all_categories()
    {
        $categories = Category::factory()->count(10)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                ],
            ],
        ]);
    }

    /**
     * Test it creates a category.
     * This method tests if the API endpoint can successfully create a new category.
     */
    public function it_creates_a_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $categoryData = [
            'title' => 'New Category',
            'description' => 'New Category Description',
        ];

        $response = $this->postJson('/api/categories', $categoryData);

        $response->assertCreated();
        $this->assertDatabaseHas('categories', ['title' => 'New Category']);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
            ],
        ]);
    }

    /**
     * Test it shows a category.
     * This method tests if the API endpoint can successfully retrieve a single category by ID.
     */
    public function it_shows_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertOk()->assertJson([
            'data' => [
                'id' => $category->id,
                'title' => $category->title,
                'description' => $category->description,
            ]
        ]);
    }

    /**
     * Test it updates a category.
     * This method tests if the API endpoint can successfully update an existing category.
     */
    public function it_updates_a_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $category = Category::factory()->create();

        $updatedData = [
            'title' => 'Updated Category Title',
            'description' => 'Updated Category Description',
        ];

        $response = $this->putJson("/api/categories/{$category->id}", $updatedData);
        $response->assertOk();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'title' => 'Updated Category Title',
            'description' => 'Updated Category Description',
        ]);

        $response->assertJson([
            'data' => [
                'id' => $category->id,
                'title' => 'Updated Category Title',
                'description' => 'Updated Category Description',
            ]
        ]);
    }

    /**
     * Test it soft deletes a category.
     * This method tests if the API endpoint can successfully soft delete a category, making it inaccessible from normal queries.
     */
    public function it_soft_deletes_a_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $category = Category::factory()->create();
        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted('categories', ['id' => $category->id]);
    }
}
