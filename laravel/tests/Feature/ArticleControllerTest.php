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
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                    'category' => [
                        'id',
                        'title',
                        'description',
                    ],
                    'tags',
                ],
            ],
        ]);
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
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'content',
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
                'category' => [
                    'id',
                    'title',
                    'description',
                ],
                'tags' => [
                    [
                        'id',
                        'title',
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function it_shows_an_article()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();
        $category = Category::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id
        ]);
        $article->tags()->attach($tag);

        $response = $this->getJson("/api/articles/{$article->id}");

        $response->assertOk()->assertJson([
            'data' => [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'category' => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'description' => $category->description,
                ],
                'tags' => [
                    [
                        'id' => $tag->id,
                        'title' => $tag->title,
                    ]
                ],
            ]
        ]);
    }

    /** @test */
    public function it_updates_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $tag = Tag::factory()->create();
        $category = Category::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);
        $article->tags()->attach($tag);

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'tags' => [$tag->id],
            'category_id' => $category->id,
        ];

        $response = $this->putJson("/api/articles/{$article->id}", $updatedData);
        $response->assertOk();

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'category_id' => $category->id,
        ]);

        $response->assertJson([
            'data' => [
                'id' => $article->id,
                'title' => 'Updated Title',
                'content' => 'Updated content',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'category' => [
                    'id' => $category->id,
                    'title' => $category->title,
                    'description' => $category->description,
                ],
                'tags' => [
                    [
                        'id' => $tag->id,
                        'title' => $tag->title,
                    ]
                ],
            ]
        ]);
    }

    /** @test */
    public function it_soft_deletes_an_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/articles/{$article->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }
}
