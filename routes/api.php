<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventoController;
use App\Http\Controllers\API\FormularioRegistroController;
use App\Http\Controllers\API\ParticipanteController;

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

Route::get('/formularios/registros',[FormularioRegistroController::class, 'index']);
Route::get('/formularios/registro/{id}',[FormularioRegistroController::class, 'show']);
Route::post('/formularios/registro',[FormularioRegistroController::class, 'store']);
Route::put('/formularios/registro/{id}',[FormularioRegistroController::class, 'update']);

Route::get('/formularios/participantes',[ParticipanteController::class, 'index']);
Route::get('/formularios/participante/{id}',[ParticipanteController::class, 'show']);
Route::post('/formularios/participante',[ParticipanteController::class, 'store']);
Route::put('/formularios/participante/{id}',[ParticipanteController::class, 'update']);
