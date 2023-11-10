<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Participante;
use App\Models\Respuesta;
use App\Models\Pregunta;
use App\Models\FormularioRegistro;
use App\Http\Controllers\API\FormularioRegistroController;
use DateTime;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $formulario = FormularioRegistro::where('id_evento', $request->input('id_evento'))->first();
        $respuestas = Respuesta::where('id_formulario', $formulario->id)->get();
        $participantes = $this->limpiarDatos($respuestas,$this->stringToArray($formulario->preguntas));
        return response()->json($participantes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $participante = $this->createParticipante($request, null);
        $guardado = $this->guardarRespuestas($request, $participante);
        if($guardado === 'incompleto')
            return response()->json(['error' => 'no se encuentran todas las preguntas del formulario'],400);

        return response()->json($guardado,200);
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
        $participante->save();
        /*if (new DateTime() < new DateTime($participante->fecha_nacimiento))
        {
            return null;
        }*/

        return $participante;
    }

    private function guardarRespuestas(Request $request, $participante)
    {
        $respuestas = $request->input('respuestas');
        $formularioController = new FormularioRegistroController;
        $formulario = $formularioController->formulario($request->input('id_formulario'));
        if(!$this->verificarFormulario($respuestas, $formulario))
            return 'incompleto';

        $arrayRespuestas = array();
        foreach ($formulario as $pregunta) {
            $resultado = null;
            foreach ($respuestas as $respuesta) {
                if($pregunta->texto_pregunta === $respuesta['pregunta'])
                    $resultado = $respuesta['respuesta'];
            }
            array_push($arrayRespuestas, $resultado);
        }
        $datosRespuesta = $this->arrayToString($arrayRespuestas);
        $res = new Respuesta;
        $res->id_formulario = $request->input('id_formulario');
        $res->id_participante = $participante->id;
        $res->datos_respuesta = $datosRespuesta;
        $res->save();
        return $res;
    }

    private function arrayToString($value)
    {
        if ($value == null)
            return null;
        return implode(",",(array)$value);
    }

    private function stringToArray($value)
    {
        if ($value == null)
            return null;
        return preg_split('/,/',$value);
    }

    private function verificarFormulario($respuestas, $formulario)
    {
        $cumpleTodos = true;
        foreach ($formulario as $pregunta) {
            $cumple = false;
            foreach ($respuestas as $respuesta) {
                if($pregunta->texto_pregunta === $respuesta['pregunta'])
                    $cumple = true;
            }
            if(!$cumple)
                $cumpleTodos = false;
        }
        return $cumple;
    }

    private function limpiarDatos($respuestas, $idPreguntas)//preguntas es array, respuestas es objeto
    {
        $preguntas = $this->getPreguntas($idPreguntas);
        array_push($preguntas, 'id');
        $participantes = array();
        foreach ($respuestas as $respuesta) {
            $arrayRespuesta = $this->stringToArray($respuesta->datos_respuesta);
            array_push($arrayRespuesta, $respuesta->id_participante);
            $participante = array_combine($preguntas, $arrayRespuesta);
            array_push($participantes, $participante);
        }
        return $participantes;
    }

    private function getPreguntas($idPreguntas)
    {
        $preguntas = array();
        foreach ($idPreguntas as $idPregunta) {
            $pregunta = Pregunta::find($idPregunta);
            array_push($preguntas, $pregunta->texto_pregunta);
        }
        return $preguntas;
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
