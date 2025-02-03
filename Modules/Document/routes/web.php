<?php

use Illuminate\Support\Facades\Route;
use Modules\Document\Http\Controllers\CategoryController;
use Modules\Document\Http\Controllers\DocumentController;

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

Route::middleware(['auth'])->group( function () {
    //Document
    Route::get('/document', [DocumentController::class,'index'])->name('document.index');
    Route::get('/document/create', [DocumentController::class,'create'])->name('document.create');
    Route::post('/document/store',[DocumentController::class, 'store'])->name('document.store');
    Route::get('/document/edit/{id}', [DocumentController::class,'edit'])->name('document.edit');
    Route::put('/document/update/{id}', [DocumentController::class,'update'])->name('document.update');
    Route::delete('/document/delete/{id}', [DocumentController::class,'destroy'])->name('document.destroy');
    Route::post('/document/attachment',[DocumentController::class, 'uploadAttachment'])->name('document.uploadAttachment');

    //DocumentCategory
    Route::get('/category', [CategoryController::class,'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class,'create'])->name('category.create');
    Route::post('/category/store',[CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class,'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class,'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class,'destroy'])->name('category.destroy');
});
