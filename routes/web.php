<?php

use Illuminate\Support\Facades\Route;

// Modules
use App\Http\Controllers\Frontend\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'api_index'])->name('documentation.api.index');


// Mails preview

Route::group(['prefix' => 'mail-preview'], function() {
  Route::get('/otp', function() {
    return new App\Mail\Users\Otp(['otp_code' => '0FG2ZKA6', 'user_name' => 'Patrick Policarpio']);
  });
});
