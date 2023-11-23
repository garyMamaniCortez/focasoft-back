<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FormularioRegistro;
use App\Models\Pregunta;
use App\Models\Evento;
use App\Http\Controllers\API\PreguntaController;
use App\Http\Controllers\API\EventoController;

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
        $formulario_registro = $this->createFormulario($request, null);

        try {
            $formulario_registro->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $formularioRequest = new Request([
            'id_formulario' => $formulario_registro->id,
            'id_evento' => $request->input('id_evento')
        ]);
        $eventoController = new EventoController();
        $eventoController->agregarFormulario($formularioRequest);

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
        return response()->json($this->formulario($id));
    }

    public function formulario($id)
    {
        $formularioRegistro = FormularioRegistro::find($id);
        return $this->mostrarFormulario($formularioRegistro);
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
        $formulario_registro = $this->createFormulario($request, $id);

        try {
            $formulario_registro->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $formularioRequest = new Request([
            'id_formulario' => $formulario_registro->id,
            'id_evento' => $request->input('id_evento')
        ]);
        $eventoController = new EventoController();
        $eventoController->agregarFormulario($formularioRequest);
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

    private function mostrarFormulario($formularioRegistro)
    {
        $Pregunta = new Pregunta;
        $arrayPreguntas = $this->stringToArray($formularioRegistro->preguntas);
        $arrayObligatorias = $this->stringToArray($formularioRegistro->obligatorias);
        $formulario = array();
        foreach ($arrayPreguntas as $pregunta) {
            $prePregunta = Pregunta::select('id','texto_pregunta','tipo','obligatorio')
                                    ->where('id',$pregunta)->first();
            $prePregunta->obligatorio = array_shift($arrayObligatorias);
            array_push($formulario, $prePregunta);
        }
        return $formulario;
    }

    private function guardarPreguntas($preguntas, $idEvento)
    {
        $evento = Evento::find($idEvento);
        foreach ($preguntas as $pregunta) {
            $request = new Request([
                'texto_pregunta' => $pregunta['pregunta'],
                'tipo' => $pregunta['tipo'],
                'equipo' => $evento->equipo,
                'obligatorio' => false,
                'opciones' => null
            ]);
            $preguntaController = new PreguntaController();
            $preguntaController->store($request);
        }
    }

    private function createFormulario(Request $request, $id)
    {
        $formularioRegistro = new FormularioRegistro;
        if ($id != null)
        {
            $formularioRegistro = FormularioRegistro::findOrFail($id);
        }
        $formularioRegistro->id_evento = $request->input('id_evento');
        if($request->input('preguntas') != null)
        {
            $this->guardarPreguntas($request->input('preguntas'), $request->input('id_evento'));
            $preguntas = $this->obtenerIdPreguntas($request->input('preguntas'));
            $obligatorias = $this->obtenerPreguntasObligatorias($request->input('preguntas'));
            $formularioRegistro->obligatorias = $obligatorias;
            $formularioRegistro->preguntas = $preguntas;
            return $formularioRegistro;
        }

        return "preguntas";
    }

    private function obtenerIdPreguntas($preguntas)
    {
        $arrayPreguntas = array();
        foreach ($preguntas as $pregunta) {
            $idPregunta = Pregunta::select('id')
                                    ->where('texto_pregunta', $pregunta['pregunta'])
                                    ->first();
            array_push($arrayPreguntas, $idPregunta->id);
        }
        return $this->arrayToString($arrayPreguntas);
    }
    private function obtenerPreguntasObligatorias($preguntas)
    {
        $arrayPreguntas = array();
        foreach ($preguntas as $pregunta) {
            array_push($arrayPreguntas, $pregunta['obligatorio'] ? 1: 0);
        }
        return $this->arrayToString($arrayPreguntas);
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
