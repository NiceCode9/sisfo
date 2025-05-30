<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('landing.index');
    })->name('home');
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

    Route::put('/users/{user}/update-password', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('users.update-password');
    Route::post('/menus/update-order', [\App\Http\Controllers\MenuController::class, 'updateOrder'])->name('menus.update-order');
});


require __DIR__ . '/auth.php';
