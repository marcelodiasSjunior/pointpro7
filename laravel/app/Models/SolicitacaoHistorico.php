<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacaoHistorico extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'funcionario_id',
        'acao',
        'anexo',
        'start_date',
        'end_date',
        'start_time',
        'end_time'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }
}
