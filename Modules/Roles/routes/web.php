<?php

use Illuminate\Support\Facades\Route;
use Modules\Roles\Http\Controllers\RolesController;

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

Route::middleware(['auth','verified','role:admin'])->group( function () {
    Route::get('/roles', [RolesController::class,'index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class,'create'])->name('roles.create');
    Route::post('/roles/store',[RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RolesController::class,'edit'])->name('roles.edit');
    Route::put('/roles/update/{id}', [RolesController::class,'update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [RolesController::class,'destroy'])->name('roles.destroy');
});
