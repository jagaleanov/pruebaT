<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="ArticleInput",
 *     type="object",
 *     title="Article input",
 *     required={"user_id", "category_id","title", "content"},
 *     properties={
 *         @OA\Property(property="category_id", type="integer", format="int64", description="Category ID"),
 *         @OA\Property(property="title", type="string", description="Article title"),
 *         @OA\Property(property="content", type="string", description="Article content"),
 *         @OA\Property(
 *             property="tags",
 *             type="array",
 *             description="Collection ogtags ID",
 *             @OA\Items(type="integer", format="int64", description="Tag ID")
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="ArticleResource",
 *     type="object",
 *     title="Article resource",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Article ID"),
 *         @OA\Property(property="title", type="string", description="Article title"),
 *         @OA\Property(property="content", type="string", description="Article content"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation time of the article"),
 *         @OA\Property(
 *             property="user",
 *             description="User object",
 *             ref="#/components/schemas/UserResource"
 *         ),
 *         @OA\Property(
 *             property="category",
 *             type="object",
 *             description="Category of the article",
 *             @OA\Property(property="id", type="integer", format="int64", description="Category ID"),
 *             @OA\Property(property="title", type="string", description="Category title"),
 *             @OA\Property(property="description", type="string", description="Category description")
 *         ),
 *         @OA\Property(
 *             property="tags",
 *             type="array",
 *             description="Collection of tags",
 *             @OA\Items(ref="#/components/schemas/TagCollection")
 *         ),
 *         @OA\Property(
 *             property="comments",
 *             type="array",
 *             description="Collection of comments",
 *             @OA\Items(ref="#/components/schemas/CommentResource")
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="ArticleCollection",
 *     type="object",
 *     title="Article collection",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Article ID"),
 *         @OA\Property(property="title", type="string", description="Article title"),
 *         @OA\Property(property="content", type="string", description="Article content"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation time of the article"),
 *         @OA\Property(
 *             property="user",
 *             description="User object",
 *             ref="#/components/schemas/UserResource"
 *         ),
 *         @OA\Property(
 *             property="category",
 *             type="object",
 *             description="Category of the article",
 *             @OA\Property(property="id", type="integer", format="int64", description="Category ID"),
 *             @OA\Property(property="title", type="string", description="Category title"),
 *             @OA\Property(property="description", type="string", description="Category description")
 *         ),
 *         @OA\Property(
 *             property="tags",
 *             type="array",
 *             description="Collection ogtags",
 *             @OA\Items(ref="#/components/schemas/TagCollection")
 *         )
 *     }
 * )
*/

class ArticleSchema{

}
