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

Route::group(['middleware' => ['auth', 'verified']], function () {

    // Home
    Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
        Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');
    });

    Route::group(['middleware' => ['role:Administrator']], function () {
        Route::group(['prefix' => 'users',  'as' => 'users.'], function () {
            Route::resource('/', \App\Http\Controllers\UserController::class);
        });
        
        Route::prefix('backend')->name('backend.')->group(function () {
        Route::resource('siswa', SiswaController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
        Route::resource('pembimbing', PembimbingController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('jurusan', \App\Http\Controllers\Backend\JurusanController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('dudi', \App\Http\Controllers\Backend\DudiController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('kuota_dudi', \App\Http\Controllers\Backend\KuotaDudiController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('tahun_pelaksanaan', \App\Http\Controllers\Backend\TahunPelaksanaanController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
        Route::resource('pengajuan_magang', \App\Http\Controllers\Backend\PengajuanMagangController::class)->only(['index']);

            // Action khusus
            Route::post('pengajuan_magang/usulkan', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'usulkan'])
                ->name('pengajuan_magang.usulkan');
            Route::post('pengajuan_magang/batalkan', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'batalkan'])
                ->name('pengajuan_magang.batalkan');
        });
                Route::prefix('backend')->name('backend.')->middleware('role:Administrator')->group(function(){
            Route::get('lihat_pengajuan', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'lihatPengajuan'])
                ->name('lihat_pengajuan');

            Route::post('lihat_pengajuan/terima', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'terimaUsulan'])
                ->name('lihat_pengajuan.terima');

            Route::post('lihat_pengajuan/tolak', [\App\Http\Controllers\Backend\PengajuanMagangController::class,'tolakUsulan'])
                ->name('lihat_pengajuan.tolak');
        });
            Route::prefix('backend')->name('backend.')->group(function(){
            Route::resource('capaian_kompetensi', \App\Http\Controllers\Backend\CapaianKompetensiController::class);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('surat_pengantar', \App\Http\Controllers\Backend\SuratPengantarController::class);
            Route::get('surat_pengantar/{id}/cetak', [\App\Http\Controllers\Backend\SuratPengantarController::class, 'cetakPDF'])
                ->name('surat_pengantar.cetak');
            Route::get('surat_pengantar/{id}/download', [\App\Http\Controllers\Backend\SuratPengantarController::class, 'download'])
                ->name('surat_pengantar.download');
        });

        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('atur_pembimbing', \App\Http\Controllers\Backend\AturPembimbingController::class)->only(['index', 'update']);
        });
        Route::prefix('backend')->name('backend.')->group(function () {
            Route::resource('logbook', \App\Http\Controllers\Backend\LogbookController::class);

        });

        Route::prefix('backend')->name('backend.')->group(function () {
            Route::get('laporan', [LaporanMagangController::class, 'index'])->name('laporan.index');
            Route::post('laporan', [LaporanMagangController::class, 'store'])->name('laporan.store');
            Route::get('laporan/download/{id}', [LaporanMagangController::class, 'download'])->name('laporan.download');
        });







    });
});

require __DIR__ . '/auth.php';
