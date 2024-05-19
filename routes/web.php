<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DynamicRouterHandler;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    if (session()->exists('auth_session')) {
        return redirect('/');
    }
    return view('login');
})->name('login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware' => 'checksession'], function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::group(['prefix' => 'devices'], function () {
        Route::get('all', function () {
            return view('devices.all');
        })->name('devices.all');
    });

    Route::group(['prefix' => 'locations'], function () {
        Route::get('all', function () {
            return view('locations.all');
        })->name('locations.all');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('all', function () {
            return view('users.all');
        })->name('users.all');
    });

    Route::get('/apis/{any}', [DynamicRouterHandler::class, 'getAPI'])->where('any', '.*');
    Route::post('/apis/{any}', [DynamicRouterHandler::class, 'postAPI'])->where('any', '.*');
    Route::put('/apis/{any}', [DynamicRouterHandler::class, 'putAPI'])->where('any', '.*');
    Route::delete('/apis/{any}', [DynamicRouterHandler::class, 'deleteAPI'])->where('any', '.*');
});
