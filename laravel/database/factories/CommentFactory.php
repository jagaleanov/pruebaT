<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'article_id' => \App\Models\Article::factory(),
            'user_id' => \App\Models\User::factory(),
            'content' => $this->faker->paragraph,
        ];
    }
}
