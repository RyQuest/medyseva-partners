<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/vle-login',[App\Http\Controllers\api\VleController::class, 'login'])->name('vle-login');

/*
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
});
*/
Route::post('/vle-appointment',[App\Http\Controllers\api\AppointmentController::class, 'index'])->name('vle-appointment');

Route::post('/vle-create-appointment',[App\Http\Controllers\api\AppointmentController::class, 'create'])->name('vle-create-appointment');

Route::post('/vle-withdraw-request',[App\Http\Controllers\api\WalletController::class, 'withdrawRequestAdd'])->name('vle-withdraw-request');


Route::post('/vle-withdraw-requests',[App\Http\Controllers\api\WalletController::class, 'withdrawRequest'])->name('vle-withdraw-requests');


Route::post('/vle-wallet-history',[App\Http\Controllers\api\WalletController::class, 'index'])->name('vle-wallet-history');

Route::post('/vle-dashboard',[App\Http\Controllers\api\AppointmentController::class, 'VleDashboard'])->name('vle-dashboard');

Route::post('/vle-patients',[App\Http\Controllers\api\VleController::class, 'vlePatient'])->name('vle-patients');
