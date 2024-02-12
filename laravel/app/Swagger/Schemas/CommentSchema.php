<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="CommentInput",
 *     type="object",
 *     title="Comment input",
 *     required={"article_id","content"},
 *     properties={
 *         @OA\Property(property="article_id", type="integer", format="int64", description="Article ID"),
 *         @OA\Property(property="content", type="string", description="Comment content")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CommentResource",
 *     type="object",
 *     title="Comment resource",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Comment ID"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation time of the article"),
 *         @OA\Property(property="content", type="string", description="Comment content"),
 *         @OA\Property(
 *             property="user",
 *             description="User object",
 *             ref="#/components/schemas/UserResource"
 *         ),
 *     }
 * )
*/

class CommentSchema{

}
