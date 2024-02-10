<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     title="Article",
 *     required={"user_id", "category_id","title", "content"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Article ID"),
 *         @OA\Property(property="user_id",  type="integer", format="int64", description="User ID"),
 *         @OA\Property(property="category_id", type="integer", format="int64", description="Category ID"),
 *         @OA\Property(property="title", type="string", description="Article title"),
 *         @OA\Property(property="content", type="string", description="Article content")
 *     }
 * )
*/

class ArticleSchema{

}
