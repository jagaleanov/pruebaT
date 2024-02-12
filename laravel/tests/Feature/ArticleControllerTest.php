<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_lists_all_articles()
    {
        $articles = Article::factory()->count(10)->create();

        $response = $this->getJson('/api/articles');

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_creates_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $tag = Tag::factory()->create();
        $category = Category::factory()->create();
        $articleData = [
            'title' => 'Test Article',
            'content' => 'Test content',
            'tags' => [$tag->id],
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/articles', $articleData);

        $response->assertCreated();
        $this->assertDatabaseHas('articles', ['title' => 'Test Article']);
    }

    /** @test */
    public function it_shows_an_article()
    {
        $article = Article::factory()->create();

        $response = $this->getJson("/api/articles/{$article->id}");

        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $article->id,
                'title' => $article->title,
            ]
        ]);
    }

    /** @test */
    public function it_updates_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $article = Article::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            // 'tags' => [$tag->id],
            'category_id' => $category->id,
        ];

        $response = $this->putJson("/api/articles/{$article->id}", $updatedData);

        $response->assertOk();
        $this->assertDatabaseHas('articles', ['title' => 'Updated Title']);
    }

    /** @test */
    // public function it_soft_deletes_an_article()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user, 'sanctum');

    //     $article = Article::factory()->create(['user_id' => $user->id]);

    //     $response = $this->deleteJson("/api/articles/{$article->id}");

    //     $response->assertNoContent();

    //     $this->assertSoftDeleted('articles', ['id' => $article->id]);
    // }

}
