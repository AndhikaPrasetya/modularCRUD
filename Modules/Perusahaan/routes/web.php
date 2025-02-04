<?php

use Illuminate\Support\Facades\Route;
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
    
});
