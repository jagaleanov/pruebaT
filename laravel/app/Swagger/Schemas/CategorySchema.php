<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="CategoryInput",
 *     type="object",
 *     title="Category input",
 *     required={"title,description"},
 *     properties={
 *         @OA\Property(property="title", type="string", description="Category title"),
 *         @OA\Property(property="description", type="string", description="Category description")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CategoryResource",
 *     type="object",
 *     title="Category resource",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Category ID"),
 *         @OA\Property(property="title", type="string", description="Category title"),
 *         @OA\Property(property="description", type="string", description="Category description"),
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
 *     schema="CategoryCollection",
 *     type="object",
 *     title="Category collection",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Category ID"),
 *         @OA\Property(property="title", type="string", description="Category title"),
 *         @OA\Property(property="description", type="string", description="Category description")
 *     }
 * )
*/

class CategorySchema{

}
