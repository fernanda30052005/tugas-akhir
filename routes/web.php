<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\SiswaController;
use App\Http\Controllers\Backend\PembimbingController;
use App\Http\Controllers\Backend\LaporanMagangController;

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

// Landing Page - Redirect to login
Route::get('/', function () {
    return redirect()->route('login');
})->name('/');

Route::group(['middleware' => ['auth']], function () {

    // Home - accessible by all roles
    Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
        Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
    });

    // Backend routes with role-based access
    Route::prefix('backend')->name('backend.')->group(function () {
        
        // Routes accessible by all authenticated users (with role checking in controllers)
        Route::get('logbook', [\App\Http\Controllers\Backend\LogbookController::class, 'index'])->name('logbook.index');
        Route::get('logbook/create', [\App\Http\Controllers\Backend\LogbookController::class, 'create'])->name('logbook.create');
        Route::post('logbook', [\App\Http\Controllers\Backend\LogbookController::class, 'store'])->name('logbook.store');
        Route::get('logbook/{logbook}/edit', [\App\Http\Controllers\Backend\LogbookController::class, 'edit'])->name('logbook.edit');
        Route::put('logbook/{logbook}', [\App\Http\Controllers\Backend\LogbookController::class, 'update'])->name('logbook.update');
        Route::delete('logbook/{logbook}', [\App\Http\Controllers\Backend\LogbookController::class, 'destroy'])->name('logbook.destroy');
        
        Route::get('laporan', [LaporanMagangController::class, 'index'])->name('laporan.index');
        Route::post('laporan', [LaporanMagangController::class, 'store'])->name('laporan.store');
        Route::get('laporan/download/{id}', [LaporanMagangController::class, 'download'])->name('laporan.download');
        
        Route::get('pengajuan_magang', [\App\Http\Controllers\Backend\PengajuanMagangController::class, 'index'])->name('pengajuan_magang.index');
        Route::post('pengajuan_magang/usulkan', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'usulkan'])->name('pengajuan_magang.usulkan');
        Route::post('pengajuan_magang/batalkan', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'batalkan'])->name('pengajuan_magang.batalkan');
        
        // Administrator only routes
        Route::group(['middleware' => ['custom.role:administrator']], function () {
            // User Management
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::resource('/', \App\Http\Controllers\UserController::class);
            });
            
            // Backend Management
            Route::resource('siswa', SiswaController::class);
            Route::resource('pembimbing', PembimbingController::class);
            Route::resource('jurusan', \App\Http\Controllers\Backend\JurusanController::class);
            Route::resource('dudi', \App\Http\Controllers\Backend\DudiController::class);
            Route::resource('kuota_dudi', \App\Http\Controllers\Backend\KuotaDudiController::class);
            Route::resource('tahun_pelaksanaan', \App\Http\Controllers\Backend\TahunPelaksanaanController::class);
            Route::resource('capaian_kompetensi', \App\Http\Controllers\Backend\CapaianKompetensiController::class);
            Route::resource('surat_pengantar', \App\Http\Controllers\Backend\SuratPengantarController::class);
            Route::resource('atur_pembimbing', \App\Http\Controllers\Backend\AturPembimbingController::class)->only(['index', 'update']);
            
            // Surat Pengantar special routes
            Route::get('surat_pengantar/{id}/cetak', [\App\Http\Controllers\Backend\SuratPengantarController::class, 'cetakPDF'])->name('surat_pengantar.cetak');
            Route::get('surat_pengantar/{id}/download', [\App\Http\Controllers\Backend\SuratPengantarController::class, 'download'])->name('surat_pengantar.download');
            
            // Lihat Pengajuan (Admin only)
            Route::get('lihat_pengajuan', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'lihatPengajuan'])->name('lihat_pengajuan');
            Route::post('lihat_pengajuan/terima', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'terimaUsulan'])->name('lihat_pengajuan.terima');
            Route::post('lihat_pengajuan/tolak', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'tolakUsulan'])->name('lihat_pengajuan.tolak');
        });
    });
});

require __DIR__ . '/auth.php';
