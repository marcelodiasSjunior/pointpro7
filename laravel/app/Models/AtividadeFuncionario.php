<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeFuncionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'funcionario_id',
        'atividade_id',
        'status'
    ];

    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function funcionario_atividade()
    {
        return $this->hasOne(FuncionarioAtividade::class);
    }

    public function observacoes()
    {
        return $this->hasMany(Observacao::class)->orderBy('created_at', 'DESC');
    }
}
