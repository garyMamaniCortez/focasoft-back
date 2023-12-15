<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventoController;
use App\Http\Controllers\API\EventoExternoController;
use App\Http\Controllers\API\GanadorController;
use App\Http\Controllers\API\FormularioRegistroController;
use App\Http\Controllers\API\ParticipanteController;
use App\Http\Controllers\API\PatrocinadorController;
use App\Http\Controllers\API\PreguntaController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

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
Route::post('/usuario', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function ()
{
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/eventos',[EventoController::class, 'index']);
Route::get('/evento/{id}',[EventoController::class, 'show']);
Route::post('/evento/', [EventoController::class, 'store']);
Route::put('/evento/{id}',[EventoController::class, 'update']);
Route::get('/evento/imagen/{id}',[EventoController::class, 'getImage']);
Route::post('/evento/buscar', [EventoController::class, 'buscar']);
//Route::post('/evento/agregarFormulario', [EventoController::class, 'agregarFormulario']);

Route::get('/eventos/externos',[EventoExternoController::class, 'index']);
Route::get('/evento/externo/{id}',[EventoExternoController::class, 'show']);
Route::post('/evento/externo',[EventoExternoController::class, 'store']);
Route::get('/evento/externo/imagen/{id}',[EventoExternoController::class, 'getImage']);

Route::post('/evento/ganadores',[GanadorController::class, 'store']);
Route::get('/evento/ganadores/{id}',[GanadorController::class, 'show']);
Route::get('/evento/excel/{id}',[GanadorController::class, 'export']);

Route::get('/formularios/registros',[FormularioRegistroController::class, 'index']);
Route::get('/formularios/registro/{id}',[FormularioRegistroController::class, 'show']);
Route::post('/formularios/registro',[FormularioRegistroController::class, 'store']);
Route::put('/formularios/registro/{id}',[FormularioRegistroController::class, 'update']);

Route::post('/formularios/participantes',[ParticipanteController::class, 'index']);
Route::post('/formularios/participantes/buscar',[ParticipanteController::class, 'buscar']);
Route::get('/formularios/participante/{id}',[ParticipanteController::class, 'show']);
Route::post('/formularios/participante',[ParticipanteController::class, 'store']);
Route::put('/formularios/participante/{id}',[ParticipanteController::class, 'update']);

Route::get('/patrocinadores',[PatrocinadorController::class, 'index']);
Route::get('/patrocinador/{id}',[PatrocinadorController::class, 'show']);
Route::post('/patrocinador',[PatrocinadorController::class, 'store']);
Route::get('/patrocinador/imagen/{id}',[PatrocinadorController::class, 'getImage']);

Route::get('/formulario/preguntas/{idEvento}',[PreguntaController::class, 'index']);
Route::post('/formulario/pregunta',[PreguntaController::class, 'store']);

Route::get('/reporte/eventos',[EventoController::class, 'reporte']);
Route::post('/reporte/eventos/buscar',[EventoController::class, 'buscarReporte']);
