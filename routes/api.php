<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Modules
use App\Http\Controllers\API\AuthenticationController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\OtpController;
use App\Http\Controllers\API\StripePaymentsController;
use App\Http\Controllers\API\EngineerCategoriesController;
use App\Http\Controllers\API\ApplicationAttachementsController;
use App\Http\Controllers\API\ApplicationRecordsController;
use App\Http\Controllers\API\InvoicesController;
use App\Http\Controllers\API\PaymentsController;

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
        Route::post('/register', [AuthenticationController::class, 'register'])->name('auth.user.register');
        Route::post('/request-otp/{email}', [OtpController::class, 'request_otp'])->name('auth.user.request-otp');
        Route::post('/verify-otp', [OtpController::class, 'verify_otp'])->name('auth.user.verify-otp');
        Route::patch('/reset-password', [AuthenticationController::class, 'reset_password'])->name('auth.user.reset-password');


        // User Data (by modules <applications ....>)
        Route::get('/{user_id}/application-records/', [UsersController::class, 'user_applications'])->name('auth.user.application-records');
        Route::get('/{user_id}/invoices/', [UsersController::class, 'user_invoices'])->name('auth.user.invoices');

        Route::group(['middleware' => 'auth:api'], function() {
            Route::get('/current-user', [AuthenticationController::class, 'current_user'])->name('auth.user.current-user');
            Route::patch('/update-profile/{user_id}', [AuthenticationController::class, 'update_profile'])->name('auth.user.update-profile');
            Route::patch('/update-password/{user_id}', [AuthenticationController::class, 'update_password'])->name('auth.user.update-password');
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

  Route::group(['prefix' => 'application-payments'], function() {
    Route::post('/create-payment', [ApplicationRecordsController::class, 'add_application_payment'])->name('payments.application.create');
  });
});

// Modules

// Users
Route::apiResource('users', UsersController::class);
Route::get('/client-accounts', [UsersController::class, 'index_client_accounts'])->name('users.client-accounts');

// Engineers
Route::apiResource('engineer-categories', EngineerCategoriesController::class);

// Application Records
Route::apiResource('application-records', ApplicationRecordsController::class);
Route::get('/application-records/get-by-uuid/{uuid}', [ApplicationRecordsController::class, 'show_by_uuid'])->name('application-records.show-by-uuid');
Route::post('/application-records/add-review', [ApplicationRecordsController::class, 'add_review'])->name('application-records.add-review');
Route::post('/application-records/update-approval', [ApplicationRecordsController::class, 'update_approval'])->name('application-records.update-approval');
Route::post('/application-attachements/upload-attachements', [ApplicationAttachementsController::class, 'upload_attachements'])->name('application-records.upload-attachements');
Route::get('/application-attachements/retrieve-attachement/{filename}', [ApplicationAttachementsController::class, 'retrieve_attachement'])->name('application-records.retrieve-attachement');

// Invoices
Route::apiResource('invoices', InvoicesController::class);
Route::get('/invoices/get-by-uuid/{uuid}', [InvoicesController::class, 'show_by_uuid'])->name('invoices.show-by-uuid');

// Payments
Route::get('/payment-records', [PaymentsController::class, 'index'])->name('payments.index');
Route::get('/payment-records/{id}', [PaymentsController::class, 'show'])->name('payments.show');
