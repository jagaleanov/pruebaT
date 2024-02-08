<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

});
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::put('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::get('tags/{id}', [TagController::class, 'show']);
Route::put('tags/{id}', [TagController::class, 'update']);
Route::delete('tags/{id}', [TagController::class, 'destroy']);

Route::get('articles', [ArticleController::class, 'index']);
Route::post('articles', [ArticleController::class, 'store']);
Route::get('articles/{id}', [ArticleController::class, 'show']);
Route::put('articles/{id}', [ArticleController::class, 'update']);
Route::delete('articles/{id}', [ArticleController::class, 'destroy']);

Route::get('comments', [CommentController::class, 'index']);
Route::post('comments', [CommentController::class, 'store']);
Route::get('comments/{id}', [CommentController::class, 'show']);
Route::put('comments/{id}', [CommentController::class, 'update']);
Route::delete('comments/{id}', [CommentController::class, 'destroy']);

Route::get('categories/{id}/articles', [ArticleController::class, 'showByCategory']);
Route::post('categories/{id}/articles', [CategoryController::class, 'setArticles']);

Route::get('tags/{id}/articles', [ArticleController::class, 'showByTag']);
Route::post('tags/{id}/articles', [CategoryController::class, 'setArticles']);

Route::get('articles/{id}/tags', [TagController::class, 'showByArticle']);
Route::post('articles/{id}/tags', [ArticleController::class, 'setTags']);

Route::get('articles/{id}/comments', [CommentController::class, 'showByArticle']);
Route::post('articles/{id}/comments', [ArticleController::class, 'setComments']);







