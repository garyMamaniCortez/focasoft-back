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
        $eventos = Evento::latest('fecha_ini')->get();
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
        if($evento == null)
        {
            return response()->json(['error' => 'El campo afiche debe ser una imagen'], 422);
        }
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
        $eventos = Evento::where('titulo','like',"%{$busqueda}%")
                    ->orWhere('tipo', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%")->latest('fecha_ini')->get();

        if (count($eventos) == 0)
        {
            return response()->json([
                'error' => 'No se encontraron eventos que coincidan con la búsqueda.',
            ], 404);
        }

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

            if ($image->getMimeType() != 'image/jpeg'
                && $image->getMimeType() != 'image/png'
                && $image->getMimeType() != 'image/tiff'
                && $image->getMimeType() != 'image/bmp')
            {
                return null;
            }

            $evento->afiche = base64_encode(file_get_contents($image->path()));
        }
        $evento->id_formulario = $request->input('id_formulario');

        $evento->requisitos = $this->arrayToString($request->input('requisitos'));
        $evento->premios = $this->arrayToString($request->input('premios'));
        $evento->patrocinadores = $this->arrayToString($request->input('patrocinadores'));
        $evento->contactos = $this->arrayToString($request->input('contactos'));

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

        $evento->requisitos = $this->stringToArray($evento->requisitos);
        $evento->premios = $this->stringToArray($evento->premios);
        $evento->patrocinadores = $this->stringToArray($evento->patrocinadores);
        $evento->contactos = $this->stringToArray($evento->contactos);

        if ($evento->afiche == null)
            return $evento;

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

    private function stringToArray($value)
    {
        if ($value == null)
            return null;
        return preg_split('/,/',$value);
    }
    private function arrayToString($value)
    {
        if ($value == null)
            return null;
        return implode(",",(array)$value);
    }
}
