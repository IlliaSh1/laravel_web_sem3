<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
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
// Galery
Route::get('/', [MainController::class, 'index']);
Route::get('galery/{img}',[MainController::class, 'show']);

// Artices
// Route::get('articles/',[ArticleController::class, 'index']);
// Route::get('articles/create',[ArticleController::class, 'create']);
// Route::post('articles/create',[ArticleController::class, 'create']);
// Route::get('articles/{article}',[ArticleController::class, 'index']);
Route::resource('/articles', ArticleController::class);
Route::get('articles/{article}',[ArticleController::class, 'show'])->name('articles.show')->middleware('path');

// Comments
Route::group(['prefix' => '/comments', 'middleware' => ['auth:sanctum']], function() {
    Route::post('/store', [CommentController::class, 'store']);//->middleware('auth:sanctum')
    Route::get('/edit/{id}', [CommentController::class, 'edit']);
    Route::post('/update/{id}', [CommentController::class, 'update']);
    Route::get('/delete/{id}', [CommentController::class, 'delete']);
    Route::get('', [CommentController::class, 'index'])->name('comments');
    Route::get('/accept/{id}', [CommentController::class, 'accept']);
    Route::get('/reject/{id}', [CommentController::class, 'reject']);
    
});
//Auth
Route::get('/create', [AuthController::class, 'create']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'customLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

// 
Route::get('contacts', function () {
    $contact = [
        'name' => "Polytech",
        'address' => "B.Semenovskay 38",
        'phone' => '8 800 555 55 55'
    ];
    
    return view('main.contact', ['contact'=>$contact]);
});