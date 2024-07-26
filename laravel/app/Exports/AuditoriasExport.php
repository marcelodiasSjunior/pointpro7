<?php

namespace App\Exports;

use App\Models\Auditoria;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuditoriasExport implements FromCollection, WithHeadings
{
    protected $company_id;
    protected $funcionario_id;
    protected $ano;
    protected $mes;

    public function __construct($company_id, $funcionario_id, $ano, $mes) {
        $this->company_id = $company_id;
        $this->funcionario_id = $funcionario_id;
        $this->ano = $ano;
        $this->mes = $mes;
    }

    public function collection()
    {
        $mesAno = $this->ano . '-' . str_pad($this->mes, 2, '0', STR_PAD_LEFT);

        $auditorias = Auditoria::where('company_id', $this->company_id)
            ->where('funcionario_id', $this->funcionario_id)
            ->where('acao', 'like', '%' . $mesAno . '%')
            ->get(['id', 'acao', 'created_at']);

        // Format the dates
        $formattedAuditorias = $auditorias->map(function ($auditoria) {
            return [
                'id' => $auditoria->id,
                'acao' => $auditoria->acao,
                'created_at' => $auditoria->created_at->format('d/m/Y H:i:s'), // Format the date
            ];
        });

        return new Collection($formattedAuditorias);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Ação',
            'Data Alteração',
        ];
    }
}
