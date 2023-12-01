<?php
namespace App\Imports;

use App\Models\Participante;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToModel;

class ParticipanteImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        $participante = Participante::find($row['id']);
        if($participante != null)
        {
            $participante->posicion = $row['posicion'];
            $participante->save();
        }
    }
    public function rules(): array
    {
        return [
            'posicion' => ['integer','required'],
            'id' => ['integer','required']
        ];
    }
}
