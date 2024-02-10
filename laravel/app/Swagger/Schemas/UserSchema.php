<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     required={"name","email","password"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="User ID"),
 *         @OA\Property(property="name", type="string", description="User name"),
 *         @OA\Property(property="email", type="string", format="email", description="User email"),
 *         @OA\Property(property="password", type="string", description="Password")
 *     }
 * )
*/

class UserSchema{

}
