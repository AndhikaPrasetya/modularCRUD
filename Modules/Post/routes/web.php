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


    Route::get('/post', [PostController::class,'index'])->name('post.index')->middleware(['auth', 'verified','role:admin|penulis']);
    Route::get('/post/create', [PostController::class,'create'])->name('post.create')->middleware(['auth', 'verified','role:admin|penulis']);
    Route::post('/post/store',[PostController::class, 'store'])->name('post.store')->middleware(['auth', 'verified','role:admin|penulis']);
    Route::get('/post/edit/{id}', [PostController::class,'edit'])->name('post.edit')->middleware(['auth', 'verified','role:admin|penulis']);
    Route::put('/post/update/{id}', [PostController::class,'update'])->name('post.update')->middleware(['auth', 'verified','role:admin|penulis']);
    Route::delete('/post/delete/{id}', [PostController::class,'destroy'])->name('post.destroy')->middleware(['auth', 'verified','role:admin|penulis']);


