<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participante;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participante = Participante::all();
        return response()->json($participante);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $participante = new Participante;
        $participante->nombres = $request->input('nombres');
        $participante->apellidos = $request->input('apellidos');
        $participante->fecha_nacimiento = $request->input('fecha_nacimiento');
        $participante->correo_electronico = $request->input('correo_electronico');
        $participante->numero_celular = $request->input('numero_celular');
        $participante->carrera = $request->input('carrera');
        $participante->talla_polera = $request->input('talla_polera');
        $participante->carnet_identidad = $request->input('carnet_identidad');
        $participante->codigo_sis_o_institucion = $request->input('codigo_sis_o_institucion');
        $participante->semestre = $request->input('semestre');
        $participante->id_formulario = $request->input('id_formulario');

        if ($participante->nombres && $participante->apellidos && $participante->fecha_nacimiento && $participante->correo_electronico && $participante->numero_celular) {
            try {
                $participante->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json($participante,201);
        } else {
            return response()->json([
                "error" => "Faltan campos obligatorios",
                "campos_obligatorios" => ["nombres", "apellidos", "fecha_nacimiento", "correo_electronico", "numero_celular"]
              ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $participante = Participante::find($id);
        return response()->json($participante);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $participante = Participante::findOrFail($id);
        $participante->nombres = $request->input('nombres');
        $participante->apellidos = $request->input('apellidos');
        $participante->fecha_nacimiento = $request->input('fecha_nacimiento');
        $participante->correo_electronico = $request->input('correo_electronico');
        $participante->numero_celular = $request->input('numero_celular');
        $participante->carrera = $request->input('carrera');
        $participante->talla_polera = $request->input('talla_polera');
        $participante->carnet_identidad = $request->input('carnet_identidad');
        $participante->codigo_sis_o_institucion = $request->input('codigo_sis_o_institucion');
        $participante->semestre = $request->input('semestre');

        if ($participante->nombres && $participante->apellidos && $participante->fecha_nacimiento && $participante->correo_electronico && $participante->numero_celular) {
            try {
                $participante->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json($participante,200);
        } else {
            return response()->json([
                "error" => "Faltan campos obligatorios",
                "campos_obligatorios" => ["nombres", "apellidos", "fecha_nacimiento", "correo_electronico", "numero_celular"]
              ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
