<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioAtividade extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'status',
        'funcionario_id',
        'company_id',
        'atividade_id',
        'atividade_funcionario_id',
        'dia_da_semana'
    ];

    public function atividadeFuncionario()
    {
        return $this->belongsTo(AtividadeFuncionario::class);
    }
}
