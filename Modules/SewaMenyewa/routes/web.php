<?php

use Illuminate\Support\Facades\Route;
use Modules\SewaMenyewa\Http\Controllers\JenisDokumenController;
use Modules\SewaMenyewa\Http\Controllers\LokasiController;
use Modules\SewaMenyewa\Http\Controllers\SewaMenyewaController;

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
    Route::get('/lokasi', [LokasiController::class,'index'])->name('lokasi.index');
    Route::get('/lokasi/create', [LokasiController::class,'create'])->name('lokasi.create')->middleware(['permission:create-lokasi']);
    Route::post('/lokasi/store',[LokasiController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/edit/{id}', [LokasiController::class,'edit'])->name('lokasi.edit')->middleware(['permission:update-lokasi']);
    Route::put('/lokasi/update/{id}', [LokasiController::class,'update'])->name('lokasi.update');
    Route::delete('/lokasi/delete/{id}', [LokasiController::class,'destroy'])->name('lokasi.destroy')->middleware(['permission:delete-lokasi']);

    Route::get('/jenisDokumen', [JenisDokumenController::class,'index'])->name('jenisDokumen.index');
    Route::get('/jenisDokumen/create', [JenisDokumenController::class,'create'])->name('jenisDokumen.create')->middleware(['permission:create-jenisDokumen']);
    Route::post('/jenisDokumen/store',[JenisDokumenController::class, 'store'])->name('jenisDokumen.store');
    Route::get('/jenisDokumen/edit/{id}', [JenisDokumenController::class,'edit'])->name('jenisDokumen.edit')->middleware(['permission:update-jenisDokumen']);
    Route::put('/jenisDokumen/update/{id}', [JenisDokumenController::class,'update'])->name('jenisDokumen.update');
    Route::delete('/jenisDokumen/delete/{id}', [JenisDokumenController::class,'destroy'])->name('jenisDokumen.destroy')->middleware(['permission:delete-jenisDokumen']);

    Route::get('/sewaMenyewa', [SewaMenyewaController::class,'index'])->name('sewaMenyewa.index');
    Route::get('/sewaMenyewa/create', [SewaMenyewaController::class,'create'])->name('sewaMenyewa.create')->middleware(['permission:create-sewaMenyewa']);
    Route::post('/sewaMenyewa/store',[SewaMenyewaController::class, 'store'])->name('sewaMenyewa.store');
    Route::get('/sewaMenyewa/edit/{id}', [SewaMenyewaController::class,'edit'])->name('sewaMenyewa.edit')->middleware(['permission:update-sewaMenyewa']);
    Route::put('/sewaMenyewa/update/{id}', [SewaMenyewaController::class,'update'])->name('sewaMenyewa.update');
    Route::delete('/sewaMenyewa/delete/{id}', [SewaMenyewaController::class,'destroy'])->name('sewaMenyewa.destroy')->middleware(['permission:delete-sewaMenyewa']);

    Route::delete('/delete-nopd/{id}', [LokasiController::class,'deleteNopd'])->name('lokasi.deleteNopd');
    Route::delete('/delete-internet/{id}', [LokasiController::class,'deleteInternet'])->name('lokasi.deleteInternet');
    Route::get('/cek-sertifikat', [SewaMenyewaController::class, 'cekSertifikatSewa']);

    
});
