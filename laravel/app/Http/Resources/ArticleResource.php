<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'user' => $this->user,
            'tags' => new TagCollection($this->tags),
            'category' => [
                'id' => $this->category->id,
                'title' => $this->category->title,
            ],
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
