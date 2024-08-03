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
$total = Carbon::createFromTime(0, 0, 0);
foreach ($horas as $hora) {
$parts = explode(':', $hora);
$total->addHours($parts[0])->addMinutes($parts[1]);
}
return $total->format('H:i');
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

return $this->{$map[$dia] ?? 'segunda'}; // Default to 'segunda' if the day is not found
}
}
