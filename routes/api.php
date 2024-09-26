<?php

use App\Http\Controllers\API\healthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Health Route
route::get('all', [healthController::class, 'all']);
route::post('store', [HealthController::class, 'store'])->name('store');
route::get('show/{id}', [healthController::class, 'show']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
