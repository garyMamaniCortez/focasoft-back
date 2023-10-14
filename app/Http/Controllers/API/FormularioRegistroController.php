<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        if(!$this->isValidForm($request))
        {
            return response()->json([
                "error" => "Debe llenar los campos obligatorios"
              ], 400);
        }

        $formulario_registro = $this->createFormulario($request, null);

        try {
            $formulario_registro->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($formulario_registro,201);
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
        if(!$this->isValidForm($request))
        {
            return response()->json([
                "error" => "Debe llenar los campos obligatorios"
              ], 400);
        }

        $formulario_registro = $this->createFormulario($request, $id);

        try {
            $formulario_registro->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($formulario_registro,200);
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

    private function createFormulario(Request $request, $id)
    {
        $formulario_registro = new FormularioRegistro;
        if ($id != null)
        {
            $formulario_registro = FormularioRegistro::findOrFail($id);
        }
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

        return $formulario_registro;
    }

    private function isValidForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required',
            'correo_electronico' => 'required',
            'numero_celular' => 'required',
            'carrera' => '',
            'talla_polera' => '',
            'carnet_identidad' => '',
            'codigo_sis_o_institucion' => '',
            'semestre' => '',
        ]);

        if ($validator->fails()) {
            return false;
        }

        if ($request->input('nombres') && $request->input('apellidos') && $request->input('fecha_nacimiento') && $request->input('correo_electronico') && $request->input('numero_celular'))
        {
            return true;
        }
        return false;
    }
}
