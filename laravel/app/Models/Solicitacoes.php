<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Funcionarios;
use App\Models\Company;

class Solicitacoes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tipo',
        'description',
        'company_id',
        'funcionario_id',
        'status',
        'data',
        'documento',
        'read',
        'page'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class, 'funcionario_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
