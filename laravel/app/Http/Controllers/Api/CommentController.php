<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Comments",
 *     description="Operations about comments"
 * )
 */
class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/comments",
     *     tags={"Comments"},
     *     summary="List all comments",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Comment")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function index()
    {
        try {
            $categories = Comment::all();
            // return $categories;
            return CommentResource::collection($categories);
        } catch (\Exception $e) {
            Log::error("Error retrieving articles: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to retrieve articles'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     tags={"Comments"},
     *     summary="Create a new comment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comment created",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function store(CommentRequest $request)
    {
        try {
            $comment = Comment::create($request->all());
            // return $comment;
            return new CommentResource($comment);
        } catch (\Exception $e) {
            Log::error('Comment store error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to save comment'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Get comment by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of comment to return",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            // return $comment;
            return new CommentResource($comment);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve comment'], Response::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }

    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Update an existing comment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of comment that needs to be updated",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment updated",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function update(CommentRequest $request, string $id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            $comment->update($request->all());
            // return $comment;
            return new CommentResource($comment);
        } catch (\Exception $e) {
            Log::error("Error updating comment: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to update comment'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     tags={"Comments"},
     *     summary="Delete a comment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the comment to delete",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content - Successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            $comment->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT); // 204 No Content
        } catch (\Exception $e) {
            Log::error("Error deleting comment: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to delete comment'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
