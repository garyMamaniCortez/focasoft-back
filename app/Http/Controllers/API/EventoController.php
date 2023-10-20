<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Evento;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = Evento::all();
        foreach ($eventos as $evento)
        {
            $evento = $this->translateEvento($evento);
        }
        return response()->json($eventos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$this->isValidTittle($request))
        {
            return response()->json([
                "error" => "El titulo del evento ya existe"
              ], 400);
        }
        $evento = $this->createEvento($request, null);
        try {
            $evento->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($evento,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evento = Evento::find($id);
        $evento = $this->translateEvento($evento);
        return response()->json($evento);
    }

    public function getImage($id)
    {
        $evento = Evento::find($id);
        if($evento->afiche != null)
        {
            if (filter_var($evento->afiche, FILTER_VALIDATE_URL))
                return $evento->afiche;
            $base64Image = $evento->afiche;
            return response(base64_decode($base64Image),200)->header('Content-Type','image/jpeg');
        }else
        {
            return "";
        }
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
        if(!$this->isValidTittleWithId($request, $id))
        {
            return response()->json([
                "error" => "El titulo del evento ya existe"
              ], 400);
        }
        $evento = $this->createEvento($request, $id);

        try {
            $evento->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($evento, 200);
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

    public function buscar(Request $request)
    {
        $busqueda = $request->input('busqueda');
        $titulosEventos = Evento::where('titulo','like',"%{$busqueda}%")->get();
        $tiposEventos = Evento::where('tipo', 'like', "%{$busqueda}%")->get();

        $arrayEventos = null;
        if (count($titulosEventos) == 0 && count($tiposEventos) == 0) {
            return response()->json([
                'error' => 'No se encontraron eventos que coincidan con la búsqueda.',
            ], 404);
        }elseif (count($titulosEventos) == 0) {
            $arrayEventos = $tiposEventos->toArray();
        }elseif (count($tiposEventos) == 0) {
            $arrayEventos = $titulosEventos->toArray();
        }else {
            $arrayEventos = array_merge($titulosEventos->toArray(), $tiposEventos->toArray());
            $arrayEventos = array_unique($arrayEventos);
        }

        $eventos = $this->arrayObjetosToArrayEventos($arrayEventos);
        foreach ($eventos as $evento)
        {
            $evento = $this->translateEvento($evento);
        }
        return response()->json($eventos, 200);
    }

    private function createEvento(Request $request, $id)
    {
        $evento = new Evento;
        $tipo = $this->validateTipoEvento($request->input('tipo'));
        if ($id != null)
        {
            $evento = Evento::findOrFail($id);
            $tipo = $evento->tipo;
        }
        $evento->titulo = $request->input('titulo');
        $evento->fecha_ini = $request->input('fecha_ini');
        $evento->fecha_fin = $request->input('fecha_fin');
        $evento->tipo = $tipo;
        $evento->descripcion = $request->input('descripcion');

        $evento->afiche = $request->input('afiche');
        if($request->hasfile('afiche'))
        {
            $image = $request->file('afiche');
            $evento->afiche = base64_encode(file_get_contents($image->path()));
        }
        $evento->id_formulario = $request->input('id_formulario');
        $evento->requisitos = $request->input('requisitos');
        $evento->premios = $request->input('premios');
        $evento->patrocinadores = $request->input('patrocinadores');
        $evento->contactos = $request->input('contactos');

        return $evento;
    }

    private function isValidTittle(Request $request)
    {
        $eventos = Evento::all();
        $response = true;
        foreach ($eventos as $evento)
        {
            if($evento->titulo === $request->input('titulo'))
            {
                $response = false;
            }
        }
        return $response;
    }

    private function isValidTittleWithId(Request $request, $id)
    {
        $eventos = Evento::all();
        $response = true;
        foreach ($eventos as $evento)
        {
            if($evento->titulo === $request->input('titulo') && $evento->id != $id)
            {
                $response = false;
            }
        }
        return $response;
    }

    private function translateEvento($evento)
    {
        $evento = $this->translateTipoEvento($evento);
        $evento->afiche = $this->getImageURL($evento->id);
        return $evento;
    }

    private function translateTipoEvento($evento)
    {
        switch ($evento->tipo) {
            case 'reclutamiento':
                $evento->tipo = 'Reclutamiento';
                break;
            case 'taller_de_entrenamiento':
                $evento->tipo = 'Taller de entrenamiento';
                break;
            case 'competencia_de_entrenamiento':
                $evento->tipo = 'Competencia de entrenamiento';
                break;
            case 'clasificatorio_interno':
                $evento->tipo = 'Clasificatorio interno';
                break;
            case 'competencia':
                $evento->tipo = 'Competencia';
                break;
            default:
                $evento->tipo = 'indefinido';
                break;
        }
        return $evento;
    }
    private function validateTipoEvento($tipo)
    {
        switch ($tipo) {
            case 'Reclutamiento':
                $tipo = 'reclutamiento';
                break;
            case 'Taller de entrenamiento':
                $tipo = 'taller_de_entrenamiento';
                break;
            case 'Competencia de entrenamiento':
                $tipo = 'competencia_de_entrenamiento';
                break;
            case 'Clasificatorio interno':
                $tipo = 'clasificatorio_interno';
                break;
            case 'Competencia':
                $tipo = 'competencia';
                break;
            default:
                $tipo = 'indefinido';
                break;
        }
        return $tipo;
    }

    private function getImageURL($id)
    {
        return "localhost:8000/api/evento/imagen/{$id}";
    }

    private function arrayObjetosToArrayEventos(array $arrayObjetos)
    {
        $arrayEventos = [];

        foreach ($arrayObjetos as $objeto) {
            $evento = new Evento();

            $evento->id = $objeto['id'];
            $evento->titulo = $objeto['titulo'];
            $evento->fecha_ini = $objeto['fecha_ini'];
            $evento->tipo = $objeto['tipo'];
            $evento->descripcion = $objeto['descripcion'];
            $evento->afiche = $objeto['afiche'];
            $evento->id_formulario = $objeto['id_formulario'];
            $evento->fecha_fin = $objeto['fecha_fin'];
            $evento->requisitos = $objeto['requisitos'];
            $evento->premios = $objeto['premios'];
            $evento->patrocinadores = $objeto['patrocinadores'];
            $evento->contactos = $objeto['contactos'];

            $arrayEventos[] = $evento;
        }

        return $arrayEventos;
    }
}
