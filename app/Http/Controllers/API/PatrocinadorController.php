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
        return Patrocinador::all();
    }

    public function patrocinador($id)
    {
        return Patrocinador::find($id);
    }

    private function crearPatrocinador(Request $request, $id)
    {
        $patrocinador = new Patrocinador;
        if($id != null)
            $patrocinador = Patrocinador::findOrFail($id);
        if($this->esNombreValido($request))
        {
            $patrocinador->nombre = $request->input('nombre');
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
