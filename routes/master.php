<?php

use App\Http\Controllers\Api\Master\DeviceController;
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
    Route::prefix('master')->group(function () {
        /**Route Master Device */
        Route::controller(DeviceController::class)->prefix('device')->name('device.')->group(function () {
            Route::post('/show', 'showData')->name('show');
            Route::get('/show-by-id/{id}', 'showDataId')->name('show-by-id');
            Route::post('/insert', 'insertData')->name('insert');
            Route::put('/update/{id}', 'updateData')->name('update');
            Route::delete('/delete/{id}', 'deleteData')->name('delete');
        });
    });
});
