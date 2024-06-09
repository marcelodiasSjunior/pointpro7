<?php

namespace App\Exports;

use App\Models\Funcionario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $company_id;

    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    public function collection()
    {
        $result = Funcionario::where('company_id', $this->company_id)->get();

        // Transforma a coleção para retornar apenas os campos desejados
        $result = $result->map(function ($funcionario) {
            return [
                'ID' => $funcionario->id,
                'Nome' => $funcionario->user->name,
                'Celular' => $funcionario->celular,
                'Email' => $funcionario->user->email,
                'Funcao' => $funcionario->funcao->title,
                'Jornada' => $funcionario->jornada->total_semanal,
                'Atividades' => $funcionario->atividades_count(),
            ];
        });

        return $result;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Celular',
            'Email',
            'Funcao',
            'Jornada',
            'Atividades',
        ];
    }
}
