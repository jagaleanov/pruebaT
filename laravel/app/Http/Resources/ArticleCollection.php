<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'created_at' => $article->created_at,
                'user' => $article->user,
                'tags' => new TagCollection($article->tags),
                'category' => [
                    'id' => $article->category->id,
                    'title' => $article->category->title,
                ],
            ];
        })->toArray();
    }
}
