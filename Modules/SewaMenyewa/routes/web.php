<?php

use Illuminate\Support\Facades\Route;
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
    Route::get('/lokasi/create', [LokasiController::class,'create'])->name('lokasi.create');
    Route::post('/lokasi/store',[LokasiController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/edit/{id}', [LokasiController::class,'edit'])->name('lokasi.edit');
    Route::put('/lokasi/update/{id}', [LokasiController::class,'update'])->name('lokasi.update');
    Route::delete('/lokasi/delete/{id}', [LokasiController::class,'destroy'])->name('lokasi.destroy');



    // //delete shareholders/directors
    Route::delete('/delete-nopd/{id}', [LokasiController::class,'deleteNopd'])->name('lokasi.deleteNopd');
    Route::delete('/delete-internet/{id}', [LokasiController::class,'deleteInternet'])->name('lokasi.deleteInternet');
    
    
});
