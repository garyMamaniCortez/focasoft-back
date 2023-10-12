<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventoController;

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

Route::get('/eventos',[EventoController::class, 'index']);
Route::get('/evento/{id}',[EventoController::class, 'show']);
Route::post('evento/', [EventoController::class, 'store']);
Route::put('/evento/{id}',[EventoController::class, 'update']);
