<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     title="Category",
 *     required={"title"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Category ID"),
 *         @OA\Property(property="title", type="string", description="Category title")
 *     }
 * )
*/

class CategorySchema{

}
