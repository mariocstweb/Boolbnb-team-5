<?php

use App\Http\Controllers\Api\ApartmentsController;
use App\Http\Controllers\Api\FilterServiceController;
use App\Http\Controllers\Api\ServicesController;
use Illuminate\Http\Request;
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

Route::apiResource('apartments', ApartmentsController::class)->only('index');
Route::get('apartments/{id}', [ApartmentsController::class, 'show']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('services', ServicesController::class)->only('index');

Route::get('services/{id}/apartments', FilterServiceController::class);
