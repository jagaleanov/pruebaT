<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Images",
 *     description="Upload images"
 * )
 */
class ImageController extends Controller
{/**
     * @OA\Post(
     *     path="/api/images",
     *     tags={"Images"},
     *     summary="Upload an image",
     *     operationId="uploadImage",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image file to upload",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="file",
     *                     description="Image file",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful upload",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="location",
     *                     type="string",
     *                     description="URL of the uploaded image",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request",
     *     ),
     * )
     */
    public function upload(Request $request)
    {
        $fileName=$request->file('file')->getClientOriginalName();
        $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        return response()->json(['location'=>"/storage/$path"]);
    }
}
