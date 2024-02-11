<?php
namespace App\Swagger\Schemas;

/**
 *
 * @OA\Schema(
 *     schema="UserInput",
 *     type="object",
 *     title="User register input",
 *     required={"name","email","password,password_confirm"},
 *     properties={
 *         @OA\Property(property="name", type="string", description="User name"),
 *         @OA\Property(property="email", type="string", format="email", description="User email"),
 *         @OA\Property(property="password", type="string", description="Password"),
 *         @OA\Property(property="password_confirm", type="string", description="Password confirm")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="UserLogin",
 *     type="object",
 *     title="User login input",
 *     required={"email","password"},
 *     properties={
 *         @OA\Property(property="email", type="string", format="email", description="User email"),
 *         @OA\Property(property="password", type="string", description="Password")
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="User resource",
 *     required={"name","email","password"},
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="User ID"),
 *         @OA\Property(property="name", type="string", description="User name"),
 *         @OA\Property(property="email", type="string", format="email", description="User email")
 *     }
 * )
*/

class UserSchema{

}
