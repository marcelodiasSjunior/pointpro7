<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcao extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'funcoes';
    protected $fillable = [
        'onboarding',
        'title',
        'company_id'
    ];

    public function atividades()
    {
        return $this->hasMany(Atividade::class);
    }
}
