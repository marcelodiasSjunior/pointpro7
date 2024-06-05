<?php

namespace App\Models;

use App\Http\Services\CommomDataService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Frequencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'funcionario_id',
        'direction',
        'document',
        'frequencia_id',
        'ponto'
    ];

    protected function pontoData(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromDate($this->ponto, 'America/Sao_Paulo')->format('d/m/Y'),
        );
    }

    protected function pontoMes(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromDate($this->ponto)->locale('pt_BR')->monthName,
        );
    }

    protected function pontoAno(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromDate($this->ponto, 'America/Sao_Paulo')->format('Y'),
        );
    }

    protected function diaSemanaNome(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromDate($this->ponto)->locale('pt_BR')->dayName,
        );
    }

    protected function diaString(): Attribute
    {
        return Attribute::make(
            get: fn () => CommomDataService::getDayOfWeekName($this->ponto),
        );
    }

    protected function hora(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromDate($this->ponto, 'America/Sao_Paulo')->format('H:i'),
        );
    }

    protected function anoNumber(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::createFromDate($this->ponto)->format('Y'),
        );
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }
}
