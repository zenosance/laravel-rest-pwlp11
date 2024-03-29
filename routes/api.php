<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ApiAuthController;
use App\Models\Mahasiswa;
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

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('/mahasiswa',MahasiswaController::class);
    Route::get('/logout',[ApiAuthController::class,'logout']);
});

Route::get('/hello', function () {
    // $data=["message"=>"Hello World"];
    // return response()->json($data);
    return "hello world";
});

Route::post('/login',[ApiAuthController::class,'login']);

Route::post('/register',[ApiAuthController::class,'register']);
