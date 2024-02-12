<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Articles",
 *     description="Operations about articles"
 * )
 */
class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articles",
     *     tags={"Articles"},
     *     summary="List all articles",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ArticleCollection")
     *         ),
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
            $articles = Article::all();
            // return $articles;
            return new ArticleCollection($articles);
        } catch (\Exception $e) {
            Log::error("Error retrieving articles: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to retrieve articles'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/articles",
     *     tags={"Articles"},
     *     summary="Create a new article",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/ArticleInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Article created",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function store(ArticleRequest $request)
    {
        try {
            $params = $request->all();
            $params['user_id'] = $request->user()->id;
            $tags = [];

            $article = Article::create($params);

            foreach ($params['tags'] as $tagId) {
                $tags[] = $tagId;
            }
            $tags = Tag::whereIn('id', $tags)->get();

            $article->tags()->attach($tags);


            // return $article;
            return new ArticleResource($article);
        } catch (\Exception $e) {
            Log::error('Article store error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to save article'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/articles/{id}",
     *     tags={"Articles"},
     *     summary="Get article by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of article to return",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $article = Article::find($id);
            if (!$article) {
                return response()->json(['message' => 'Article not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            // return $article;
            return new ArticleResource($article);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve article'], Response::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }

    /**
     * @OA\Put(
     *     path="/api/articles/{id}",
     *     tags={"Articles"},
     *     summary="Update an existing article",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of article that needs to be updated",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/ArticleInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article updated",
     *         @OA\JsonContent(ref="#/components/schemas/ArticleResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function update(ArticleRequest $request, string $id)
    {
        try {
            $article = Article::find($id);
            if (!$article) {
                return response()->json(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
            }
            $article->update($request->all());

            $article->tags()->detach();

            // Asociar los nuevos tags
            if ($request->has('tags')) {
                $tags = [];
                foreach ($request->get('tags') as $tagId) {
                    $tags[] = $tagId;
                }
                $tags = Tag::whereIn('id', $tags)->get();
                $article->tags()->attach($tags);
            }

            return new ArticleResource($article);
        } catch (\Exception $e) {
            Log::error("Error updating article: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to update article'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/articles/{id}",
     *     tags={"Articles"},
     *     summary="Deletes an article",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the article to delete",
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
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
            $article = Article::find($id);
            if (!$article) {
                return response()->json(['message' => 'Article not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
            }
            $article->delete();
            return response()->json(null, Response::HTTP_NO_CONTENT); // 204 No Content
        } catch (\Exception $e) {
            Log::error("Error deleting article: {$e->getMessage()}");
            return response()->json(['message' => 'Failed to delete article'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}