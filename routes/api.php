<?php

use App\Http\Controllers\API\healthController;
use App\Http\Controllers\API\intelligenceController;
use App\Http\Controllers\API\userController;
use Illuminate\Support\Facades\Route;

route::middleware('auth:sanctum')->group(function () {
    // Health Route
    route::get('all', [healthController::class, 'all']);
    route::post('store', [HealthController::class, 'store'])->name('store');
    route::get('show/{id}', [healthController::class, 'show']);
    route::get('Soft-Delete/{id}', [healthController::class, 'softDelete']);
    route::get('restore/softDelet/{id}', [healthController::class, 'restore_softDelete']);

    // User Auth
    Route::get('getUser', [userController::class, 'getUser']);
    Route::get('logout', [userController::class, 'logout']);

    //intelligence
    route::post('intelligence/insert', [intelligenceController::class, 'store_intelligence'])->name('store.intelligence');
    route::get('intelligence/search/{id}', [intelligenceController::class, 'search_intelligence'])->name('search.intelligence');


    //family
    route::post('family/insert', [intelligenceController::class, 'store_family'])->name('store.family');
});


Route::post('login', [userController::class, 'Login']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
