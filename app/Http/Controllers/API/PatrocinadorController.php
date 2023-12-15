<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patrocinador;

class PatrocinadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patrocinadores = $this->patrocinadores();
        return response()->json($patrocinadores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patrocinador = $this->crearPatrocinador($request, null);
        if($patrocinador == 'nombre')
            return response()->json(['ok'=>'El patrocinador ya se encuentra en la base de datos'], 200);
        if($patrocinador == 'logo')
            return response()->json(['error' => 'El campo logo debe ser una imagen'], 422);

        try {
            $patrocinador->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($patrocinador,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patrocinador = $this->patrocinador($id);
        return response()->json($patrocinador);
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

    public function patrocinadores()
    {
        $patrocinadores = Patrocinador::all();
        foreach ($patrocinadores as $patrocinador) {
            $patrocinador = $this->logoToURL($patrocinador);
        }
        return $patrocinadores;
    }

    public function patrocinador($id)
    {
        return $this->logoToURL(Patrocinador::find($id));
    }
    public function getImage($id)
    {
        $patrocinador = Patrocinador::find($id);
        if($patrocinador->logo != null)
        {
            if (filter_var($patrocinador->logo, FILTER_VALIDATE_URL))
                return $patrocinador->logo;
            $base64Image = $patrocinador->logo;
            return response(base64_decode($base64Image),200)->header('Content-Type','image/jpeg');
        }
        return "";
    }

    private function logoToURL($patrocinador)
    {
        if ($patrocinador->logo != null)
            $patrocinador->logo = $this->getImageURL($patrocinador->id);
        return $patrocinador;
    }

    private function getImageURL($id)
    {
        return "localhost:8000/api/patrocinador/imagen/{$id}";
    }
    private function crearPatrocinador(Request $request, $id)
    {
        $patrocinador = new Patrocinador;
        if($id != null)
            $patrocinador = Patrocinador::findOrFail($id);
        if($this->esNombreValido($request))
        {
            $patrocinador->nombre = $request->input('nombre');
            $patrocinador->pagina_web = $request->input('pagina_web');
            $patrocinador->logo = $request->input('logo');
            if($request->hasfile('logo'))
            {
                $image = $request->file('logo');

                if ($image->getMimeType() != 'image/jpeg'
                    && $image->getMimeType() != 'image/png'
                    && $image->getMimeType() != 'image/tiff'
                    && $image->getMimeType() != 'image/bmp')
                {
                    return 'logo';
                }

                $patrocinador->logo = base64_encode(file_get_contents($image->path()));
            }
            return $patrocinador;
        }
        return 'nombre';
    }

    private function esNombreValido(Request $request)
    {
        $patrocinadores = $this->patrocinadores();
        $response = true;
        foreach ($patrocinadores as $patrocinador)
        {
            if($patrocinador->nombre === $request->input('nombre'))
            {
                $response = false;
            }
        }
        return $response;
    }
}
