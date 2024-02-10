<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Comment",
 *     type="object",
 *     title="Comment",
 *     required={"user_id","article_id","content"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Comment ID"),
 *         @OA\Property(property="user_id",  type="integer", format="int64", description="User ID"),
 *         @OA\Property(property="article_id", type="integer", format="int64", description="Article ID"),
 *         @OA\Property(property="content", type="string", description="Comment content")
 *     }
 * )
*/

class CommentSchema{

}
