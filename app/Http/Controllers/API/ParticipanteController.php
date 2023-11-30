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
        $participantes = $this->participantes($request->input('id_evento'));
        return response()->json($participantes);
    }

    public function participantes($idEvento)
    {
        $formulario = FormularioRegistro::where('id_evento', $idEvento)->first();
        if($formulario != null)
        {
            $respuestas = Respuesta::where('id_formulario', $formulario->id)->get();
            $participantes = $this->limpiarDatos($respuestas,$this->stringToArray($formulario->preguntas));
            return count($participantes);
        }
        return null;
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

        if($guardado === 'formato')
            return response()->json(['error' => 'el formato de las respuestas es incorrecto'],400);

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

        if(!$this->esFormatoValido($formulario, $respuestas))
            return 'formato';
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
        return $cumpleTodos;
    }

    private function limpiarDatos($respuestas, $idPreguntas)
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

    private function esFormatoValido($preguntas, $respuestas)
    {
        $cumpleTodos = true;
        foreach ($preguntas as $pregunta) {
            $cumple = false;
            foreach ($respuestas as $respuesta) {
                if($pregunta->texto_pregunta === $respuesta['pregunta'])
                    if($this->formatoValido($pregunta, $respuesta['respuesta']))
                        $cumple = true;
            }
            if(!$cumple)
                $cumpleTodos = false;
        }
        return $cumpleTodos;
    }
    private function formatoValido($pregunta, $respuesta)
    {
        $cumple = false;
        switch ($pregunta->tipo) {
            case 'nombre':
                $cumple = ctype_alpha(trim(str_replace(' ','',$respuesta)));
                break;
            case 'texto':
                $cumple = ctype_alnum(trim(str_replace(' ','',$respuesta)));
                break;
            case 'telefono':
                $cumple = ctype_digit($respuesta);
                break;
            case 'fecha_AFA':
                $cumple = strtotime($respuesta);
                break;
            case 'email':
                $cumple = filter_var($respuesta, FILTER_VALIDATE_EMAIL);
                break;
            default:
                $cumple = false;
                break;
        }
        return $cumple;
    }
}
