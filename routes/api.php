<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BotController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('uploadgambarberita/{berita}', [AdminController::class, 'uploadGambarBerita']);
Route::post('deletegambarberita', [AdminController::class, 'deleteGambarBerita']);
Route::get('chatbot', [BotController::class, 'incomingMessage']);