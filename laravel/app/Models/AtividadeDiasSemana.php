<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeDiasSemana extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'dia_da_semana',
        'atividade_id'
    ];
}
