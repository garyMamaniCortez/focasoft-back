<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\EventoExterno;
use DateTime;

class EventoExternoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = $this->eventos();
        return response()->json($eventos, 200);
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
        $evento = $this->crearEvento($request, null);
        if($evento == 'afiche')
        {
            return response()->json(['error' => 'El campo afiche debe ser una imagen'], 422);
        }
        if($evento == 'fecha')
        {
            return response()->json(['error' => 'La fecha de inicio no puede ser anterior a la fecha actual'], 400);
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
        $evento = EventoExterno::find($id);
        if ($evento == null)
        {
            return response()->json([
                'error' => 'No se encontraron eventos con ese ID.',
            ], 404);
        }
        if ($evento->afiche != null)
            $evento->afiche = $this->getImageURL($evento->id);
        return response()->json($evento,200);
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
        //
    }

    public function getImage($id)
    {
        $evento = EventoExterno::find($id);
        if($evento->afiche != null)
        {
            if (filter_var($evento->afiche, FILTER_VALIDATE_URL))
                return $evento->afiche;
            $base64Image = $evento->afiche;
            return response(base64_decode($base64Image),200)->header('Content-Type','image/jpeg');
        }
        return "";
    }

    private function eventos(){
        $eventos = EventoExterno::latest('fecha_ini')->get();
        foreach ($eventos as $evento)
        {
            if ($evento->afiche != null)
                $evento->afiche = $this->getImageURL($evento->id);
        }
        return $eventos;
    }
    private function getImageURL($id)
    {
        return "localhost:8000/api/evento/externo/imagen/{$id}";
    }

    private function isValidTittle(Request $request)
    {
        $titulos = EventoExterno::select('titulo')
                                ->where('titulo', $request->input('titulo'))
                                ->get();
        if(count($titulos) == 0)
            return true;
    }

    private function crearEvento(Request $request, $id)
    {
        $evento = new EventoExterno;
        if ($id != null)
        {
            $evento = EventoExterno::findOrFail($id);
        }
        $evento->titulo = $request->input('titulo');
        $evento->fecha_ini = $request->input('fecha_ini');
        if (new DateTime() > new DateTime($evento->fecha_ini))
        {
            return 'fecha';
        }
        $evento->fecha_fin = $request->input('fecha_fin');
        $evento->url = $request->input('url');
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
                return 'afiche';
            }

            $evento->afiche = base64_encode(file_get_contents($image->path()));
        }

        return $evento;
    }
}
