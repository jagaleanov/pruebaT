<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Tags",
 *     description="Operations about tags"
 * )
 */
class TagController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tags",
     *     tags={"Tags"},
     *     summary="List all tags",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="some word from the name of the tag",
     *         required=false,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TagCollection")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $query = Tag::query();

            if ($request->has('search')) {
                $search = $request->query('search');
                $query->where('title', 'like', "%{$search}%");
            }

            $tags = $query->get();

            return new TagCollection($tags);
        } catch (\Exception $e) {
            Log::error("Error retrieving tags: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to retrieve tags'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/tags",
     *     tags={"Tags"},
     *     summary="Create a new tag",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/TagInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tag created",
     *         @OA\JsonContent(ref="#/components/schemas/TagResource")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function store(TagRequest $request)
    {
        try {
            $tag = Tag::create($request->all());
            // return $tag;
            return new TagResource($tag);
        } catch (\Exception $e) {
            Log::error('Tag store error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to save tag'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tags/{id}",
     *     tags={"Tags"},
     *     summary="Get tag by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of tag to return",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TagResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag) {
                return response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            // return $tag;
            return new TagResource($tag);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve tag'], Response::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }

    /**
     * @OA\Put(
     *     path="/api/tags/{id}",
     *     tags={"Tags"},
     *     summary="Update an existing tag",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of tag that needs to be updated",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/TagInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tag updated",
     *         @OA\JsonContent(ref="#/components/schemas/TagResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function update(TagRequest $request, string $id)
    {
        try {
            $tag = Tag::find($id);
            if (!$tag) {
                return response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            $tag->update($request->all());
            // return $tag;
            return new TagResource($tag);
        } catch (\Exception $e) {
            Log::error("Error updating tag: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to update tag'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/tags/{id}",
     *     tags={"Tags"},
     *     summary="Deletes a tag",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the tag to delete",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content",
     *         description="Tag successfully deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag not found"
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
            $tag = Tag::find($id);
            if (!$tag) {
                return response()->json(['message' => 'Tag not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            $tag->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT); // 204 No Content
        } catch (\Exception $e) {
            Log::error("Error deleting tag: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to delete tag'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
