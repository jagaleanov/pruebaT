<?php

use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ArticleController::class, 'index']);
Route::get('articles/create', [ArticleController::class, 'create']);
Route::post('articles/store', [ArticleController::class, 'store']);
Route::get('articles/show/{id}', [ArticleController::class, 'show']);

Route::post('comments/store', [CommentController::class, 'store']);

Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::get('register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
