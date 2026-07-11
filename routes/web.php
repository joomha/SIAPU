<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\PengajuanSuratController;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\Admin\BltController;
use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ChatbotController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/layanan-mandiri', [PublicController::class, 'layananMandiri'])->name('public.layanan_mandiri');
Route::post('/layanan-mandiri/store', [PublicController::class, 'storePengajuan'])->name('public.store_pengajuan');
Route::get('/cek-status', [PublicController::class, 'cekStatus'])->name('public.cek_status');
Route::post('/api/chat', [ChatbotController::class, 'respond']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin,validator'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('warga', WargaController::class);
    Route::resource('jenis-surat', JenisSuratController::class);
    Route::resource('surat', SuratController::class);
    Route::get('surat/{surat}/download', [SuratController::class, 'download'])->name('surat.download');
    Route::resource('pengajuan-surat', PengajuanSuratController::class);
    Route::resource('arsip', ArsipController::class);
    Route::resource('blt', BltController::class);
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
