<?php
namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Login",
 *     type="object",
 *     title="Login",
 *     required={"email","password"},
 *     properties={
 *         @OA\Property(property="email", type="string", format="email", description="User email"),
 *         @OA\Property(property="password", type="string", description="Password")
 *     }
 * )
*/

class LoginSchema{

}
