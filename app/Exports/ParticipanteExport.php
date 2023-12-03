<?php
namespace App\Exports;

//use App\Models\Participante;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipanteExport implements FromArray, WithHeadings
{
    protected $participantes;
    public function __construct(array $participantes)
    {
        $this->participantes = $participantes;
    }

    public function headings():array
    {
        $headers = array();
        foreach($this->participantes as $participante)
            foreach ($participante as $key => $value) {
                if(!in_array($key,$headers))
                    array_push($headers, $key);
            }

        array_push($headers,'posicion');
        return $headers;
    }

    public function array(): array
    {
        return $this->participantes;
    }
}
