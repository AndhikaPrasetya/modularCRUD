<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;

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

Route::group([], function () {
    Route::resource('post', PostController::class)->names('post');
});

Route::middleware(['auth', 'verified','role:admin|penulis'])->group(function () {
    Route::get('/post', [PostController::class,'index'])->name('post.index');
    Route::get('/post/create', [PostController::class,'create'])->name('post.create');
    Route::post('/post/store',[PostController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{id}', [PostController::class,'edit'])->name('post.edit');
    Route::put('/post/update/{id}', [PostController::class,'update'])->name('post.update');
    Route::delete('/post/delete/{id}', [PostController::class,'destroy'])->name('post.destroy');
});