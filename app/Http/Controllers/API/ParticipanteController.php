<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Participante;
use App\Models\FormularioRegistro;
use DateTime;

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
        if(!$this->isValidForm($request))
        {
            return response()->json([
                "error" => "Debe llenar los campos obligatorios"
              ], 400);
        }
        $participante = $this->createParticipante($request, null);

        if($participante == null)
        {
            return response()->json(['error' => 'La fecha no puede ser posterior a la actual'], 422);
        }

        try {
            $participante->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($participante,201);
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
        if(!$this->isValidForm($request))
        {
            return response()->json([
                "error" => "Debe llenar los campos obligatorios"
              ], 400);
        }
        $participante = $this->createParticipante($request, $id);
        try {
            $participante->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($participante,200);
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

    private function createParticipante(Request $request, $id)
    {
        $participante = new Participante;
        if ($id != null)
        {
            $participante = Participante::findOrFail($id);
        }
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

        if (new DateTime() < new DateTime($participante->fecha_nacimiento))
        {
            return null;
        }

        return $participante;
    }

    private function isValidForm(Request $request)
    {
        $formulario = FormularioRegistro::find($request->input('id_formulario'))->toArray();
        $validator = Validator::make($request->all(), [
            'nombres' => ($formulario['nombres'] == 1) ? 'required' : '',
            'apellidos' => ($formulario['apellidos'] == 1) ? 'required' : '',
            'fecha_nacimiento' => ($formulario['fecha_nacimiento'] == 1) ? 'required' : '',
            'correo_electronico' => ($formulario['correo_electronico'] == 1) ? 'required|email' : '',
            'numero_celular' => ($formulario['numero_celular'] == 1) ? 'required|numeric' : '',
            'carrera' => ($formulario['carrera'] == 1) ? 'required' : '',
            'talla_polera' => ($formulario['talla_polera'] == 1) ? 'required' : '',
            'carnet_identidad' => ($formulario['carnet_identidad'] == 1) ? 'required' : '',
            'codigo_sis_o_institucion' => ($formulario['codigo_sis_o_institucion'] == 1) ? 'required' : '',
            'semestre' => ($formulario['semestre'] == 1) ? 'required' : '',
            'id_formulario' => 'required'
        ]);

        if ($validator->fails()) {
            return false;
        }
        return true;
    }
}
