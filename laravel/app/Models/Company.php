<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'logo',
        'seguimento',
        'razao_social',
        'cnpj',
        'telefone',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'state_id',
        'city_id'
    ];
}
