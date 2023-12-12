<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participante;
use App\Models\Evento;
use App\Imports\ParticipanteImport;
use App\Exports\ParticipanteExport;
use App\Http\Controllers\API\ParticipanteController;
use Maatwebsite\Excel\Facades\Excel;

class GanadorController extends Controller
{
    public function store(Request $request)
    {
        if(!$this->eventoValido($request->input('id_evento')))
            return response()->json(['error' => 'El tipo de evento no permite tener ganadores'],400);
        $evento = Evento::find($request->input('id_evento'));
        if($evento->ganadores == true)
            return response()->json(['error' => 'El evento ya tiene ganadores registrados'],400);
        try
        {
            if($request->hasfile('excel'))
            {
                $excel = $request->file('excel');

                if ($excel->getMimeType() != 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                    return response()->json(['error' => 'El archivo debe ser de tipo .xlsx'], 422);

                Excel::import(new ParticipanteImport, $excel);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Los campos id y posicion son obligatorios y de tipo entero'], 500);
        }
        $evento->ganadores = true;
        $evento->save();
        return response()->json();
    }

    public function show($id)
    {
        if(!$this->eventoValido($id))
            return response()->json(['error' => 'El tipo de evento no permite tener ganadores'],400);
        $evento = Evento::find($id);
        if($evento->ganadores == null || $evento->ganadores == false)
            return response()->json(['error' => 'El evento no tiene ganadores registrados'],400);

        $participanteController = new ParticipanteController;
        $participantes = $participanteController->participantes($id);
        $posiciones = array();
        foreach ($participantes as $participante) {
            $posicionParticipante = Participante::find($participante['id']);
            $posicion = new Participante;
            $posicion->nombre = $evento->equipo ? $participante['Nombre Equipo'] : $participante['Nombres'];
            $posicion->posicion = $posicionParticipante->posicion;
            array_push($posiciones, $posicion);
        }
        return response()->json($posiciones, 200);
    }

    public function export($id)
    {
        if(!$this->eventoValido($id))
            return response()->json(['error' => 'El tipo de evento no permite tener ganadores'],400);
        $evento = Evento::find($id);

        $participanteController = new ParticipanteController;
        $participantes = $participanteController->participantes($id);
	if($participantes == null)
	    return response()->json(['error' => 'El evento no tiene participantes registrados'],400);

        foreach($participantes as $participante)
            $participante['posicion'] = null;

        $export = new ParticipanteExport($participantes);
        return Excel::download($export, "Participantes $evento->titulo.xlsx");
    }

    private function eventoValido($idEvento)
    {
        $evento = Evento::find($idEvento);
        if($evento == null)
            return false;

        if($evento->tipo == 'competencia_de_entrenamiento'
            || $evento->tipo == 'clasificatorio_interno'
            || $evento->tipo == 'competencia')
            return true;
        return false;
    }
}
