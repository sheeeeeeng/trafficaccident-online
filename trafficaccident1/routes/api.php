<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartMapController;
use App\Http\Controllers\PatrolController;
use App\Http\Controllers\TALogController;
use App\Http\Controllers\A1A2A3Controller;
use App\Http\Controllers\CauseController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\drinkMapController;
use App\Http\Controllers\UserdatachangeController;
use App\Http\Controllers\analyzeController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('ta')->group(function () {

    Route::middleware(['auth:api'])->group(function () {

        Route::Resource('ta_log', TALogController::class);
        Route::Resource('ta_patrol', PatrolController::class);
        Route::Resource('chart_map', ChartMapController::class);

    });

});

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/user_list', [AuthController::class, 'index']);
        Route::post('/user_list', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
    });

});
Route::middleware(['auth:api'])->group(function () {
    Route::get("/A1A2A3",[A1A2A3Controller::class,'getData']);
    Route::get("/CaseCause",[CauseController::class,'getData']);
    Route::get("/Time",[TimeController::class,'getData']);
    Route::get("/drinkMap",[drinkMapController::class,'getData']);
    Route::get("/getdata",[UserdatachangeController::class,'getdata']);
    Route::get("/changedata",[UserdatachangeController::class,'changedata']);
    Route::get("/analyze",[analyzeController::class,'getData']);
    Route::get("/analyze2",[analyzeController::class,'getallData']);
    Route::get("/test",[analyzeController::class,'testA']);
});

