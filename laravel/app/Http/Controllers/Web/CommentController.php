<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $params = [
                'content' => $request->content,
                'article_id' => $request->article_id,
                'user_id' => $request->user()->id,
            ];
            $comment = Comment::create($params);

            return redirect('articles/show/'.$request->article_id)->with('success', 'Article created successfully');
        } catch (\Exception $e) {
            Log::error('Article store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save article');
        }
    }
}
