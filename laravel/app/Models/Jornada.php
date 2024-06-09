<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Jornada extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'company_id',
        'segunda',
        'terca',
        'quarta',
        'quinta',
        'sexta',
        'sabado',
        'domingo'
    ];



    protected function totalSemanal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->segunda + $this->terca + $this->quarta + $this->quinta + $this->sexta + $this->sabado + $this->domingo,
        );
    }
}
