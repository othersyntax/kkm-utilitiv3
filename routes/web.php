<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardkkmController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FasilitiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BandinganController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//DASHBOARD
Route::get('/utama', [HomeController::class, 'index'])->middleware(['auth'])->name('utama');
Route::get('/post', [HomeController::class, 'post'])->middleware(['auth'])->name('post');
Route::any('/dashboard',[DashboardkkmController::class, 'index'])->middleware(['auth'])->name('post');
Route::post('/fasiliti',[DashboardkkmController::class, 'ajaxFasiliti'])->middleware(['auth'])->name('post');
Route::get('/bandingan',[BandinganController::class, 'index'])->middleware(['auth'])->name('post');
Route::post('/getDataBandingan',[BandinganController::class, 'getDataBandingan'])->middleware(['auth'])->name('post');

//PENGGUNA
Route::prefix("/pentadbir/pengguna")->middleware(['auth', 'pentadbir'])->group(function(){
    Route::get('/senarai', [PenggunaController::class, 'index'])->name('pengguna.senarai');
    Route::post('/simpan', [PenggunaController::class, 'store']);
    Route::get('/ubah/{id}', [PenggunaController::class, 'edit']);
    Route::post('/kemaskini', [PenggunaController::class, 'update']);
    Route::get('/setpass/{id}', [PenggunaController::class, 'setPass']);
    Route::post('/ajax-all', [PenggunaController::class, 'ajaxAll']);
});

//FASILITI
Route::prefix("/pentadbir/fasiliti")->middleware(['auth', 'pentadbir'])->group(function(){
    Route::get('/senarai', [FasilitiController::class, 'index'])->name('fasiliti.senarai');
    Route::post('/simpan', [FasilitiController::class, 'store']);
    Route::get('/ubah/{id}', [FasilitiController::class, 'edit']);
    Route::post('/kemaskini', [FasilitiController::class, 'update']);
    Route::post('/ajax-all', [FasilitiController::class, 'ajaxAll']);
    Route::delete('/padam/{id}', [FasilitiController::class, 'destroy']);
});

//KATEGORI
Route::prefix("/pentadbir/kategori")->middleware(['auth', 'pentadbir'])->group(function(){
    Route::get('/senarai', [KategoriController::class, 'index'])->name('kategori.senarai');
    Route::post('/simpan', [KategoriController::class, 'store']);
    Route::get('/ubah/{id}', [KategoriController::class, 'edit']);
    Route::post('/kemaskini', [KategoriController::class, 'update']);
    Route::post('/ajax-all', [KategoriController::class, 'ajaxAll']);
    Route::delete('/padam/{id}', [KategoriController::class, 'destroy']);
});

//UPLOAD EXCEL
Route::prefix("/pentadbir/data")->middleware(['auth', 'pentadbir'])->group(function(){
    Route::get('/senarai', [DataController::class, 'index']);
    Route::post('/simpan', [DataController::class, 'muatnaik']);
});

Route::get('/keluar', [HomeController::class, 'logout'])->name('logout1');
require __DIR__.'/auth.php';
