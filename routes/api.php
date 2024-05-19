<?php

use App\Http\Controllers\Authentication\AuthController;
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

/** ---------Register and Login ----------- */
Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('auth.login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', 'logout')->name('logout');
            Route::post('/change-password', 'changePassword')->name('changePassword');
            Route::post('/change-profile-picture', 'changeProfilePicture')->name('changeProfilePicture');
            Route::get('menu-access', 'getMenuAccess')->name('getMenuAccess');
        });
    });
});
