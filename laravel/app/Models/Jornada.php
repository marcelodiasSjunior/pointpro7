<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

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
            get: fn () => $this->getTotalHorasSemanal(),
        );
    }

    private function getTotalHorasSemanal()
    {
        return $this->sumHoras([
            $this->segunda,
            $this->terca,
            $this->quarta,
            $this->quinta,
            $this->sexta,
            $this->sabado,
            $this->domingo
        ]);
    }

    private function sumHoras($horas)
    {
        $totalMinutes = 0;
        foreach ($horas as $hora) {
            $parts = explode(':', $hora);
            $totalMinutes += $parts[0] * 60 + $parts[1];
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function getHorasDia($dia)
    {
        $map = [
            'segunda-feira' => 'segunda',
            'terça-feira' => 'terca',
            'quarta-feira' => 'quarta',
            'quinta-feira' => 'quinta',
            'sexta-feira' => 'sexta',
            'sábado' => 'sabado',
            'domingo' => 'domingo'
        ];

        $horaString = $this->{$map[$dia] ?? 'segunda'}; // Default to 'segunda' if the day is not found
        $horaCarbon = Carbon::parse($horaString);
        return $horaCarbon->hour + ($horaCarbon->minute / 60) + ($horaCarbon->second / 3600);
    }
}
