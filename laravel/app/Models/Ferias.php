<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ferias extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'funcionario_id',
        'company_id',
        'path',
        'file',
        'media_type',
        'dateUpload',
        'startDate',
        'endDate',
        'status',
        'observacao'
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getStatusAttribute($value)
    {
        return match ($value) {
            'pendente' => 'Pendente',
            'aprovado' => 'Aprovado',
            'rejeitado' => 'Rejeitado',
            default => $value,
        };
    }
}
