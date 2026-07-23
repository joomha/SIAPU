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
use App\Http\Controllers\Admin\CmsArticleController;
use App\Http\Controllers\Admin\CmsGalleryController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SettingController;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Warga\PortalController;
use App\Http\Controllers\Kades\ApprovalController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/layanan-mandiri', [PublicController::class, 'layananMandiri'])->name('public.layanan_mandiri');
Route::post('/layanan-mandiri', [PublicController::class, 'storePengajuan'])->name('public.store_pengajuan');
Route::get('/layanan-mandiri/form-isian/{id}', [PublicController::class, 'getFormIsian'])->name('public.form_isian');
Route::get('/cek-status', [PublicController::class, 'cekStatus'])->name('public.cek_status');
Route::get('/verify/{kode}', [PublicController::class, 'verifyQr'])->name('public.verify_qr');
Route::post('/api/chat', [ChatbotController::class, 'respond']);

use App\Http\Controllers\Admin\DashboardController;

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'validator') return redirect()->route('kades.dashboard');
    if ($role === 'warga') return redirect()->route('warga.dashboard');
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('warga/import', [WargaController::class, 'import'])->name('warga.import');
    Route::get('warga/download-template', [WargaController::class, 'downloadTemplate'])->name('warga.template');
    Route::resource('warga', WargaController::class);
    Route::resource('jenis-surat', JenisSuratController::class);
    Route::resource('surat', SuratController::class);
    Route::get('surat/{surat}/download', [SuratController::class, 'download'])->name('surat.download');
    Route::resource('pengajuan-surat', PengajuanSuratController::class);
    Route::get('pengajuan-surat/{id}/preview', [PengajuanSuratController::class, 'preview'])->name('pengajuan-surat.preview');
    Route::post('pengajuan-surat/{id}/validasi', [PengajuanSuratController::class, 'validasi'])->name('pengajuan-surat.validasi');
    Route::resource('arsip', ArsipController::class);
    Route::resource('blt', BltController::class);
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export_pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export_excel');
    
    // Backup
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [BackupController::class, 'downloadDb'])->name('backup.download');
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity_log.index');
    Route::resource('artikel', CmsArticleController::class);
    Route::resource('galeri', CmsGalleryController::class);
});

Route::middleware(['auth', 'role:validator'])->prefix('kades')->name('kades.')->group(function () {
    Route::get('/dashboard', [ApprovalController::class, 'index'])->name('dashboard');
    Route::post('/pengajuan/{id}/approve', [ApprovalController::class, 'approve'])->name('approve');
    Route::get('/pengajuan/{id}/preview', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'preview'])->name('pengajuan.preview');
});

Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'index'])->name('dashboard');
    Route::post('/pengajuan', [PortalController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/form-isian/{id}', [PortalController::class, 'getFormIsian'])->name('pengajuan.form_isian');
    Route::put('/pengajuan/{id}/revisi', [PortalController::class, 'updateRevisi'])->name('pengajuan.revisi');
    Route::post('/ganti-sandi', [PortalController::class, 'updatePassword'])->name('ganti-sandi');
    Route::get('/profil', [PortalController::class, 'profil'])->name('profil');
    Route::post('/profil', [PortalController::class, 'updateProfil'])->name('profil.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/api/notif-count', [App\Http\Controllers\Admin\PengajuanSuratController::class, 'getNotifCount'])->name('api.notif-count');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
