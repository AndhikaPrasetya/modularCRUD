<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

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



Route::middleware(['auth', 'verified','role:admin|super admin'])->group(function () {
    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::get('/users/create', [UserController::class,'create'])->name('users.create');
    Route::post('/users/store',[UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class,'edit'])->name('users.edit');
    Route::put('/users/update/{id}', [UserController::class,'update'])->name('users.update');
    Route::delete('/users/delete/{id}', [UserController::class,'destroy'])->name('users.destroy');
});