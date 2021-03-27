<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Modules
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\ApplicationRecordsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function() {
    Route::group(['prefix' => 'user'], function() {
        Route::post('/login', [AuthenticationController::class, 'login'])->name('auth.user.login');

        Route::group(['middleware' => 'auth:api'], function() {
            Route::post('/current-user', [AuthenticationController::class, 'current_user'])->name('auth.user.current-user');
            Route::post('/logout', [AuthenticationController::class, 'logout'])->name('auth.user.logout');
        });
    });
});


Route::apiResource('application-records', ApplicationRecordsController::class);
