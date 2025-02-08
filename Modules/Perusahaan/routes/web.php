<?php

use Illuminate\Support\Facades\Route;
use Modules\Perusahaan\Http\Controllers\AktaPerusahaanController;
use Modules\Perusahaan\Http\Controllers\PerusahaanController;

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
    Route::get('/perusahaan', [PerusahaanController::class,'index'])->name('perusahaan.index');
    Route::get('/perusahaan/create', [PerusahaanController::class,'create'])->name('perusahaan.create');
    Route::post('/perusahaan/store',[PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::get('/perusahaan/edit/{id}', [PerusahaanController::class,'edit'])->name('perusahaan.edit');
    Route::put('/perusahaan/update/{id}', [PerusahaanController::class,'update'])->name('perusahaan.update');
    Route::delete('/perusahaan/delete/{id}', [PerusahaanController::class,'destroy'])->name('perusahaan.destroy');
    Route::get('/perusahaan/domisili', [PerusahaanController::class, 'getPerusahaanDomisili'])->name('perusahaan.domisili');


    Route::get('/aktaPerusahaan', [AktaPerusahaanController::class,'index'])->name('aktaPerusahaan.index');
    Route::get('/aktaPerusahaan/create', [AktaPerusahaanController::class,'create'])->name('aktaPerusahaan.create');
    Route::post('/aktaPerusahaan/store',[AktaPerusahaanController::class, 'store'])->name('aktaPerusahaan.store');
    Route::get('/aktaPerusahaan/edit/{id}', [AktaPerusahaanController::class,'edit'])->name('aktaPerusahaan.edit');
    Route::put('/aktaPerusahaan/update/{id}', [AktaPerusahaanController::class,'update'])->name('aktaPerusahaan.update');
    Route::delete('/aktaPerusahaan/delete/{id}', [AktaPerusahaanController::class,'destroy'])->name('aktaPerusahaan.destroy');
    Route::delete('/aktaPerusahaan/delete-file/{id}', [AktaPerusahaanController::class,'deleteFile'])->name('aktaPerusahaan.deleteFile');
    Route::post('/aktaPerusahaan/upload-temp', [AktaPerusahaanController::class, 'uploadTemp']);

    //delete shareholders/directors
    Route::delete('/delete-direktur/{id}', [AktaPerusahaanController::class,'deleteDirektur'])->name('aktaPerusahaan.deleteDirektur');
    Route::delete('/delete-saham/{id}', [AktaPerusahaanController::class,'deleteSaham'])->name('aktaPerusahaan.deleteSaham');
    
    
});
