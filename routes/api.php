<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Modules
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\StripePaymentsController;
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

// User Auth
Route::group(['prefix' => 'auth'], function() {
    Route::group(['prefix' => 'user'], function() {
        Route::post('/login', [AuthenticationController::class, 'login'])->name('auth.user.login');
        Route::post('/request-otp/{email}', [OtpController::class, 'request_otp'])->name('auth.user.request-otp');
        Route::post('/verify-otp', [OtpController::class, 'verify_otp'])->name('auth.user.verify-otp');

        Route::group(['middleware' => 'auth:api'], function() {
            Route::post('/current-user', [AuthenticationController::class, 'current_user'])->name('auth.user.current-user');
            Route::post('/logout', [AuthenticationController::class, 'logout'])->name('auth.user.logout');
        });
    });
});

// Payments
Route::group(['prefix' => 'payments'], function() {
  Route::group(['prefix' => 'stripe'], function() {
    Route::get('/get-payments', [StripePaymentsController::class, 'get_all_payments'])->name('payments.stripe.index');
    Route::get('/get-payment/{payment_charge_id}', [StripePaymentsController::class, 'get_payment'])->name('payments.stripe.show');
    Route::post('/create-payment/{application_payment_record_uuid}', [StripePaymentsController::class, 'create_payment'])->name('payments.stripe.create');
  });
});

// Modules
Route::apiResource('application-records', ApplicationRecordsController::class);
Route::get('/application-records/get-by-uuid/{uuid}', [ApplicationRecordsController::class, 'show_by_uuid'])->name('application-records.show-by-uuid');
