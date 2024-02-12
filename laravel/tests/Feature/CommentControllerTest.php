<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_lists_all_comments()
    {
        $comments = Comment::factory()->count(10)->create();

        $response = $this->getJson('/api/comments');

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'created_at',
                    'content',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_creates_a_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $article = Article::factory()->create(['user_id' => $user->id]);
        $commentData = [
            'article_id' => $article->id,
            'content' => 'This is a comment',
        ];

        $response = $this->postJson('/api/comments', $commentData);

        $response->assertCreated();
        $this->assertDatabaseHas('comments', ['content' => 'This is a comment']);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'created_at',
                'content',
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_shows_a_comment()
    {
        $comment = Comment::factory()->create();

        $response = $this->getJson("/api/comments/{$comment->id}");

        $response->assertOk()->assertJson([
            'data' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'email' => $comment->user->email,
                ],
            ]
        ]);
    }

    /** @test */
    public function it_updates_a_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $comment = Comment::factory()->create();

        $updatedData = [
            'content' => 'Updated Comment Text',
            'article_id' => $comment->article_id,
        ];

        $response = $this->putJson("/api/comments/{$comment->id}", $updatedData);
        $response->assertOk();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Updated Comment Text',
        ]);

        $response->assertJson([
            'data' => [
                'id' => $comment->id,
                'content' => 'Updated Comment Text',
            ]
        ]);
    }

    /** @test */
    public function it_deletes_a_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted('comments', ['id' => $comment->id]);
    }
}