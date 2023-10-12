<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormularioRegistro;

class FormularioRegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formulario_registro = FormularioRegistro::all();
        return response()->json($formulario_registro);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formulario_registro = new FormularioRegistro;
        $formulario_registro->nombres = $request->input('nombres');
        $formulario_registro->apellidos = $request->input('apellidos');
        $formulario_registro->fecha_nacimiento = $request->input('fecha_nacimiento');
        $formulario_registro->correo_electronico = $request->input('correo_electronico');
        $formulario_registro->numero_celular = $request->input('numero_celular');
        $formulario_registro->carrera = $request->input('carrera');
        $formulario_registro->talla_polera = $request->input('talla_polera');
        $formulario_registro->carnet_identidad = $request->input('carnet_identidad');
        $formulario_registro->codigo_sis_o_institucion = $request->input('codigo_sis_o_institucion');
        $formulario_registro->semestre = $request->input('semestre');

        if ($formulario_registro->nombres && $formulario_registro->apellidos && $formulario_registro->fecha_nacimiento && $formulario_registro->correo_electronico && $formulario_registro->numero_celular) {
            try {
                $formulario_registro->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json($formulario_registro,201);
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
        $formulario_registro = FormularioRegistro::find($id);
        return response()->json($formulario_registro);
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
        $formulario_registro = FormularioRegistro::findOrFail($id);
        $formulario_registro->nombres = $request->input('nombres');
        $formulario_registro->apellidos = $request->input('apellidos');
        $formulario_registro->fecha_nacimiento = $request->input('fecha_nacimiento');
        $formulario_registro->correo_electronico = $request->input('correo_electronico');
        $formulario_registro->numero_celular = $request->input('numero_celular');
        $formulario_registro->carrera = $request->input('carrera');
        $formulario_registro->talla_polera = $request->input('talla_polera');
        $formulario_registro->carnet_identidad = $request->input('carnet_identidad');
        $formulario_registro->codigo_sis_o_institucion = $request->input('codigo_sis_o_institucion');
        $formulario_registro->semestre = $request->input('semestre');

        if ($formulario_registro->nombres && $formulario_registro->apellidos && $formulario_registro->fecha_nacimiento && $formulario_registro->correo_electronico && $formulario_registro->numero_celular) {
            try {
                $formulario_registro->save();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            return response()->json($formulario_registro,200);
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
