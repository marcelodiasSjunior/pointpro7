<?php

namespace App\Exports;

use App\Models\Funcionario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FuncionariosExport implements FromCollection, WithHeadings
{
    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection()
    {
        $customer_data = Funcionario::where('company_id', $this->companyId)->get();
        return $customer_data;
    }

    public function headings(): array
    {
        return ['ID', 'Nome', 'Celular', 'Email', 'Funcao', 'Jornada', 'Atividades'];
    }
}
