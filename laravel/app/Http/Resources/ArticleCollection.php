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
                'id' => $this->id,
                'title' => $this->title,
                'content' => $this->content,
                'created_at' => $this->created_at,
                'user' => $this->user,
                'category' => $this->category,
                'tags' => $this->tags,
            ];
        })->toArray();
    }
}
