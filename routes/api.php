<?php

use App\Http\Controllers\API\health_intelligencesController;
use App\Http\Controllers\API\healthController;
use App\Http\Controllers\API\intelligenceController;
use App\Http\Controllers\API\partyController;
use App\Http\Controllers\API\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

route::middleware(['auth:sanctum', 'lang'])->group(function () {
    // Health Route
    // route::get('health/all', [healthController::class, 'all']);
    // route::post('health/store', [HealthController::class, 'store'])->name('health.store');
    // route::get('health/show/{id}', [healthController::class, 'show']);
    // route::post('health/Soft-Delete/{id}', [healthController::class, 'softDelete']);
    // route::post('health/restore/{id}', [healthController::class, 'restore_softDelete']);
    // route::post('health/update/{id}', [healthController::class, 'update'])->name('health.update');


    route::get('health/all', [health_intelligencesController::class, 'all']);
    route::post('health/store', [health_intelligencesController::class, 'health_store'])->name('health.store');
    route::get('health/show/{id}', [health_intelligencesController::class, 'show']);
    route::post('health/update/{id}', [health_intelligencesController::class, 'health_update'])->name('health.update');

    //intelligence
    route::post('intelligence/update/{id}', [health_intelligencesController::class, 'update_intelligence'])->name('intelligence.update');
    route::get('intelligence/search/{id}', [health_intelligencesController::class, 'search_intelligence'])->name('intelligence.search');


    route::post('health/Soft-Delete/{id}', [health_intelligencesController::class, 'softDelete']);
    route::post('health/restore/{id}', [health_intelligencesController::class, 'restore_softDelete']);

    // User Auth
    Route::get('getUser', [userController::class, 'getUser']);
    Route::get('logout', [userController::class, 'logout']);






    //party
    route::post('party/store', [partyController::class, 'store'])->name('party.store');
    route::get('party/all', [partyController::class, 'all'])->name('party.all');
    route::get('party/trash', [partyController::class, 'show_only_trash'])->name('party.trash');
    route::post('party/update/{id}', [partyController::class, 'update'])->name('party.update');
    Route::post('/party/delete/{id}', [PartyController::class, 'softDelete']);
    Route::post('/parties/restore/{id}', [PartyController::class, 'restore']);



    // language
    Route::get('change/language', function () {
        setcookie('lang', 'ckb', time() + (60 * 24 * 365), '/');

        return    app()->getLocale();
    });
});


Route::post('login', [userController::class, 'Login']);
