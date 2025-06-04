<?php

use Illuminate\Support\Facades\Route;
use Modules\Elearning\Http\Controllers\ElearningController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('elearnings', ElearningController::class)->names('elearning');
});
