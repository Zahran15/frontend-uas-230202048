<?php

use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});
Route::resource('peminjaman', \App\Http\Controllers\PeminjamanController::class);
Route::resource('buku', \App\Http\Controllers\BukuController::class);

Route::get('/buku/export/pdf', [BukuController::class, 'exportPDF'])->name('buku.export.pdf');
Route::get('/peminjaman/export-pdf/{id}', [PeminjamanController::class, 'exportSinglePDF'])->name('peminjaman.export.single');