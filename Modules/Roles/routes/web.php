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

Route::middleware(['auth','verified','role:admin|super admin'])->group( function () {
    Route::get('/roles', [RolesController::class,'index'])->name('roles.index');
    Route::get('/roles/create', [RolesController::class,'create'])->name('roles.create')->middleware(['permission:create role']);
    Route::post('/roles/store',[RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RolesController::class,'edit'])->name('roles.edit')->middleware(['permission:update role']);
    Route::put('/roles/update/{id}', [RolesController::class,'update'])->name('roles.update');
    Route::delete('/roles/delete/{id}', [RolesController::class,'destroy'])->name('roles.destroy')->middleware(['permission:delete role']);
    Route::get('/roles/addPermission/{Roleid}', [RolesController::class,'addPermission'])->name('roles.permission')->middleware(['permission:set permission role']);
    Route::put('/roles/givePermission/{Roleid}', [RolesController::class,'givePermissionToRole'])->name('roles.givePermission');
    Route::get('/roles/getDataRole', [RolesController::class,'getDataRole']);
});
