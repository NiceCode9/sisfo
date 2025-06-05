<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('landing.index');
    })->name('home');

    Route::controller('App\Http\Controllers\FrontController')->group(function () {
        Route::get('/pendaftaran', 'pendaftaran')->name('pendaftaran');
    });

    Route::post('/pendaftaran', [\App\Http\Controllers\CalonSiswaController::class, 'store'])->name('pendaftaran.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified'], 'as' => 'admin.'], function () {
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    Route::resource('menus', \App\Http\Controllers\MenuController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('tahun-ajaran', \App\Http\Controllers\TahunAjaranController::class);
    Route::resource('jalur-pendaftaran', \App\Http\Controllers\JalurPendaftaranController::class);
    Route::resource('biaya-pendaftaran', \App\Http\Controllers\BiayaPendaftaranController::class);
    Route::resource('jadwal-ppdb', \App\Http\Controllers\JadwalPpdbController::class);
    Route::resource('kuota-pendaftaran', \App\Http\Controllers\KuotaPendaftaranController::class);

    Route::put('/users/{user}/update-password', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('users.update-password');
    Route::post('/menus/update-order', [\App\Http\Controllers\MenuController::class, 'updateOrder'])->name('menus.update-order');

    // Calon Siswa Route (Pendaftar)
    Route::controller('\App\Http\Controllers\CalonSiswaController')->group(function () {
        Route::get('/calon-siswa', 'index')->name('calon-siswa.index');
        Route::get('/calon-siswa/create', 'create')->name('calon-siswa.create');
        Route::post('/calon-siswa', 'store')->name('calon-siswa.store');
        Route::get('/calon-siswa/{id}', 'show')->name('calon-siswa.show');
        Route::get('/calon-siswa/{id}/edit', 'edit')->name('calon-siswa.edit');
        Route::put('/calon-siswa/{id}', 'update')->name('calon-siswa.update');
        Route::delete('/calon-siswa/{id}', 'destroy')->name('calon-siswa.destroy');
        Route::put('/calon-siswa/{id}/status', 'updateStatus')->name('calon-siswa.update-status');
    });

    Route::controller('\App\Http\Controllers\PembayaranController')->group(function () {
        Route::get('/pembayaran', 'index')->name('pembayaran.index');
        Route::post('/pembayaran/{calonSiswa}', 'store')->name('pembayaran.store');
        Route::post('/pembayaran/{id}', 'show')->name('pembayaran.show');
    });

    // Laporan Routes
    Route::controller('\App\Http\Controllers\LaporanPembayaranController')->group(function () {
        Route::get('/laporan/pembayaran', 'index')->name('laporan.pembayaran');
        Route::get('/laporan/pembayaran/excel', 'exportExcel')->name('laporan.pembayaran.excel');
        Route::get('/laporan/pembayaran/pdf', 'exportPdf')->name('laporan.pembayaran.pdf');
    });
});


require __DIR__ . '/auth.php';
