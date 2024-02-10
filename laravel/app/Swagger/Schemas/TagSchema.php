<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Tag",
 *     type="object",
 *     title="Tag",
 *     required={"title"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="Tag ID"),
 *         @OA\Property(property="title", type="string", description="Tag title")
 *     }
 * )
 *
*/

class TagSchema{

}
