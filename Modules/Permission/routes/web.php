<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\PermissionController;

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
Route::middleware(['auth','verified','role:admin|super admin'])->group( function () {
    Route::get('/permission', [PermissionController::class,'index'])->name('permission.index');
    Route::get('/permission/create', [PermissionController::class,'create'])->name('permission.create');
    Route::post('/permission/store',[PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/edit/{id}', [PermissionController::class,'edit'])->name('permission.edit');
    Route::put('/permission/update/{id}', [PermissionController::class,'update'])->name('permission.update');
    Route::delete('/permission/delete/{id}', [PermissionController::class,'destroy'])->name('permission.destroy');
});
