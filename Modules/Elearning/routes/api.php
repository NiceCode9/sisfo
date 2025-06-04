<?php

use Illuminate\Support\Facades\Route;
use Modules\Elearning\Http\Controllers\ElearningController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('elearnings', ElearningController::class)->names('elearning');
});
