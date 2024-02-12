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
            'user' => new UserResource($this->user),
            'category' => [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'description' => $this->category->description,
            ],
            'tags' => new TagCollection($this->tags),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
