<?php

use App\Http\Controllers\Api\Transaction\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('transaction')->group(function () {
        /**Route Transaction Location */
        Route::controller(LocationController::class)->prefix('location')->name('location.')->group(function () {
            Route::post('/insert-sensecap', 'insertDataSenseCap')->name('insert-sensecap');
            Route::post('/show-device', 'showDataNodeEui')->name('show-device');
            // Route::post('/show', 'showData')->name('show');
            // Route::get('/show-by-id/{id}', 'showDataId')->name('show-by-id');
            // Route::post('/insert', 'insertData')->name('insert');
            // Route::put('/update/{id}', 'updateData')->name('update');
            // Route::delete('/delete/{id}', 'deleteData')->name('delete');
        });
    });
});
