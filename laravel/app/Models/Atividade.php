<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atividade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'funcao_id',
        'description'
    ];

    public function atividade_dias_semana()
    {
        return $this->hasMany(AtividadeDiasSemana::class);
    }

    public function atividade_funcionario()
    {
        return $this->hasMany(AtividadeFuncionario::class);
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }
}
