<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/register', [AuthController::class, 'index']);
Route::post('/auth/register', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::group(['prefix' => 'comment', 'middleware'=>'auth:sanctum'], function(){
    Route::post('', [CommentController::class, 'store']);
    Route::get('/{comment}/edit', [CommentController::class, 'edit']);
    Route::put('/{comment}', [CommentController::class, 'update']);
    Route::get('/{comment}/delete', [CommentController::class, 'destroy']);
    Route::get('/{comment}/accept', [CommentController::class, 'accept']);
    Route::get('/{comment}/reject', [CommentController::class, 'reject']);
    Route::get('/new', [CommentController::class, 'index']);

});

//Route::get('/', [MainController::class, 'index']);
Route::get('/', [ArticleController::class, 'index']);
Route::resource('articles', ArticleController::class)->middleware('auth:sanctum',
    'schedul');;

Route::get('/about', [MainController::class, 'about']);
Route::get('/contacts', [MainController::class, 'contacts']);
Route::get('/gallery/{image_url}', [MainController::class, 'gallery']);
