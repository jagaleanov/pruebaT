<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="TagInput",
 *     type="object",
 *     title="Tag input",
 *     required={"title"},
 *     properties={
 *         @OA\Property(property="title", type="string", description="Tag title")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="TagResource",
 *     type="object",
 *     title="Tag resource",
 *     required={"title"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Tag ID"),
 *         @OA\Property(property="title", type="string", description="Tag title"),
 *         @OA\Property(
 *             property="articles",
 *             type="array",
 *             description="Collection of articles",
 *             @OA\Items(ref="#/components/schemas/ArticleCollection")
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="TagCollection",
 *     type="object",
 *     title="Tag collection",
 *     required={"title"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Tag ID"),
 *         @OA\Property(property="title", type="string", description="Tag title")
 *     }
 * )
*/

class TagSchema{

}
