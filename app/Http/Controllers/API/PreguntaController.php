<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Evento;

class PreguntaController extends Controller
{
    public function index($idEvento)
    {
        $preguntas = $this->preguntasParaEvento($idEvento);
        return response()->json($preguntas);
    }

    public function store(Request $request)
    {
        $pregunta = $this->crearPregunta($request, null);
        if($pregunta == 'texto_pregunta')
            return response()->json(['ok'=>'La pregunta ya se encuentra en la base de datos'], 200);

        try {
            $pregunta->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($pregunta,201);
    }

    private function preguntas()
    {
        return pregunta::all();
    }

    private function crearPregunta(Request $request, $id)
    {
        $pregunta = new Pregunta;
        if($id != null)
            $pregunta = Pregunta::findOrFail($id);
        if($this->esNombreValido($request))
        {
            $pregunta->texto_pregunta = $request->input('texto_pregunta');
            $pregunta->tipo = $request->input('tipo');
            $pregunta->obligatorio = $request->input('obligatorio');
            $pregunta->opciones = $request->input('opciones');

            $pregunta->equipo = false;
            if($request->input('equipo') != null)
                $pregunta->equipo = $request->input('equipo');

            return $pregunta;
        }
        return 'texto_pregunta';
    }

    private function esNombreValido(Request $request)
    {//se puede mejorar con un where
        $preguntas = $this->preguntas();
        $response = true;
        foreach ($preguntas as $pregunta)
        {
            if($pregunta->texto_pregunta === $request->input('texto_pregunta'))
            {
                $response = false;
            }
        }
        return $response;
    }

    private function preguntasParaEvento($idEvento)
    {
        $evento = Evento::find($idEvento);
        return Pregunta::where('equipo', $evento->equipo)->get();
    }
}
