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

    /**
     * Test it lists all comments.
     * This method tests if the API endpoint can successfully list all comments.
     */
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

    /**
     * Test it creates a comment.
     * This method tests if the API endpoint can successfully create a new comment associated with an article.
     */
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

    /**
     * Test it shows a comment.
     * This method tests if the API endpoint can successfully retrieve a single comment by ID.
     */
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

    /**
     * Test it updates a comment.
     * This method tests if the API endpoint can successfully update an existing comment.
     */
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

    /**
     * Test it soft deletes a comment.
     * This method tests if the API endpoint can successfully soft delete a comment, making it inaccessible from normal queries.
     */
    public function it_soft_deletes_a_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $comment = Comment::factory()->create();

        $response = $this->deleteJson("/api/comments/{$comment->id}");

        $response->assertNoContent();
        $this->assertSoftDeleted('comments', ['id' => $comment->id]);
    }
}
