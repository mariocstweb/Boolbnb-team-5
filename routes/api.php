<?php

use App\Http\Controllers\Api\ApartmentsController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\FilterServiceController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ServicesController;
use App\Models\Session as ModelsSession;
use App\Models\User;
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

Route::get('apartments/filter', [FilterController::class, 'index']);

Route::post('/messages', [MessageController::class, 'store']);

Route::apiResource('apartments', ApartmentsController::class)->only('index');

Route::get('apartments/{id}', [ApartmentsController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('services', ServicesController::class)->only('index');

Route::get('services/{id}/apartments', FilterServiceController::class);

// User route
Route::get('/user', function () {
    $user = ModelsSession::select('user_id')->get();
    $userTarget = User::where('id', '=', $user[0]['user_id'])->get();
    return response()->json($userTarget);
});
