<?php

namespace App\Exports;

use App\Models\Feriado;
use App\Models\Ferias;
use App\Models\Frequencia;
use App\Models\Funcionario;
use App\Models\Jornada;
use App\Models\Atestado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FrequenciasExport implements FromCollection, WithHeadings
{
    protected $company_id;
    protected $funcionario_id;
    protected $ano;
    protected $mes;
    protected $atestados;
    protected $ferias;
    protected $feriados;
    protected $funcionario;

    public function __construct($company_id, $funcionario_id, $ano, $mes)
    {
        $this->company_id = $company_id;
        $this->funcionario_id = $funcionario_id;
        $this->ano = $ano;
        $this->mes = $mes;
        $this->funcionario = $this->getFuncionario();
        $this->atestados = $this->getAtestados() ?? collect();
        $this->ferias = $this->getFerias() ?? collect();
        $this->feriados = $this->getFeriados() ?? collect();
    }

    protected function getFuncionario()
    {
        return Funcionario::where('id', $this->funcionario_id)
            ->where('company_id', $this->company_id)
            ->first();
    }

    protected function getAtestados()
    {
        if (!$this->funcionario) {
            return collect();
        }

        return Atestado::where('user_id', $this->funcionario->user_id)
            ->where(function ($query) {
                $start = Carbon::create($this->ano, $this->mes, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();
                $query->where('startDate', '<=', $end)
                    ->where('endDate', '>=', $start);
            })
            ->get();
    }

    protected function getFerias()
    {

        if (!$this->funcionario) {
            return collect();
        }

        return Ferias::where('funcionario_id', $this->funcionario->id)
            ->where(function ($query) {
                $start = Carbon::create($this->ano, $this->mes, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();
                $query->where('startDate', '<=', $end)
                    ->where('endDate', '>=', $start)
                    ->where('status', 'aprovado');
            })
            ->get();
            
    }

    protected function getFeriados()
    {
        return Feriado::where(function ($query) {
                $start = Carbon::create($this->ano, $this->mes, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();
                $query->where('startDate', '<=', $end)
                    ->where('endDate', '>=', $start);
            })
            ->get();
            
    }

    public function collection()
    {
        $startDate = Carbon::parse("{$this->ano}-{$this->mes}-01");
        $endDate = $startDate->copy()->endOfMonth();
        $today = Carbon::now()->startOfDay();
        $allDays = collect();
        $totalSaldoMinutos = 0;

        while ($startDate->lte($endDate)) {
            $allDays->push($startDate->copy());
            $startDate->addDay();
        }

        $frequencias = Frequencia::where('company_id', $this->company_id)
            ->where('funcionario_id', $this->funcionario_id)
            ->whereBetween('ponto', [$endDate->copy()->startOfMonth(), $endDate->copy()->endOfMonth()])
            ->orderBy('ponto')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->ponto)->format('Y-m-d');
            });

        $jornada = $this->funcionario->jornada;

        $data = $allDays->map(function ($date) use ($frequencias, $jornada, &$totalSaldoMinutos, $today) {
            $day = $date->format('d/m/Y');
            $month = $date->translatedFormat('F');
            $year = $date->format('Y');
            $week = $date->translatedFormat('l');

            if ($date->gt($today)) {
                return $this->createFutureDayRow($day, $month, $year, $week);
            }

            if ($this->hasAtestadoForDate($date)) {
                return $this->createAtestadoDayRow($date, $jornada, $day, $month, $year, $week, $totalSaldoMinutos);
            }

            if ($this->hasFeriasForDate($date)) {
                return $this->createFeriasDayRow($date, $jornada, $day, $month, $year, $week, $totalSaldoMinutos);
            }

            if($this->hasFeriadosForDate($date)){
                return $this->createFeriadoDayRow($date, $jornada, $day, $month, $year, $week, $totalSaldoMinutos);
            }

            return $this->processNormalDay($date, $frequencias, $jornada, $day, $month, $year, $week, $totalSaldoMinutos);
        });

        $this->addTotalRow($data, $totalSaldoMinutos);

        return $data;
    }

    protected function hasAtestadoForDate(Carbon $date)
    {
        return $this->atestados->isNotEmpty() && $this->atestados->contains(function ($atestado) use ($date) {
            $start = Carbon::parse($atestado->startDate)->startOfDay();
            $end = Carbon::parse($atestado->endDate)->endOfDay();
            return $date->between($start, $end);
        });
    }

    protected function hasFeriasForDate(Carbon $date)
    {
        return $this->ferias->isNotEmpty() && $this->ferias->contains(function ($ferias) use ($date) {
            $start = Carbon::parse($ferias->startDate)->startOfDay();
            $end = Carbon::parse($ferias->endDate)->endOfDay();
            return $date->between($start, $end);
        });
    }

    protected function hasFeriadosForDate(Carbon $date)
    {
        return $this->feriados->isNotEmpty() && $this->feriados->contains(function ($feriado) use ($date) {
            $start = Carbon::parse($feriado->startDate)->startOfDay();
            $end = Carbon::parse($feriado->endDate)->endOfDay();
            return $date->between($start, $end);
        });
    }

    protected function createFutureDayRow($day, $month, $year, $week)
    {
        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => '-',
            'Início do intervalo' => '-',
            'Fim do intervalo' => '-',
            'Fim da jornada' => '-',
            'Status' => '-',
            'Saldo' => '-',
            'Totalizador' => ''
        ];
    }

    protected function createAtestadoDayRow(Carbon $date, Jornada $jornada, $day, $month, $year, $week, &$totalSaldoMinutos)
    {
        $diaDaSemana = strtolower($date->isoFormat('dddd'));
        $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
        $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

        $saldoMinutos = 0;
        $totalSaldoMinutos += $saldoMinutos;

        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => 'Abonado',
            'Início do intervalo' => 'Abonado',
            'Fim do intervalo' => 'Abonado',
            'Fim da jornada' => 'Abonado',
            'Status' => 'Abonado',
            'Saldo' => '00:00',
            'Totalizador' => ''
        ];
    }

    protected function createFeriasDayRow(Carbon $date, Jornada $jornada, $day, $month, $year, $week, &$totalSaldoMinutos)
    {
        $diaDaSemana = strtolower($date->isoFormat('dddd'));
        $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
        $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

        $saldoMinutos = 0;
        $totalSaldoMinutos += $saldoMinutos;

        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => 'Férias',
            'Início do intervalo' => 'Férias',
            'Fim do intervalo' => 'Férias',
            'Fim da jornada' => 'Férias',
            'Status' => 'Férias',
            'Saldo' => '00:00',
            'Totalizador' => ''
        ];
    }

    protected function createFeriadoDayRow(Carbon $date, Jornada $jornada, $day, $month, $year, $week, &$totalSaldoMinutos)
    {
        $diaDaSemana = strtolower($date->isoFormat('dddd'));
        $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
        $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

        $saldoMinutos = 0;
        $totalSaldoMinutos += $saldoMinutos;

        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => 'Feriado',
            'Início do intervalo' => 'Feriado',
            'Fim do intervalo' => 'Feriado',
            'Fim da jornada' => 'Feriado',
            'Status' => 'Feriado',
            'Saldo' => '00:00',
            'Totalizador' => ''
        ];
    }

    protected function processNormalDay(Carbon $date, $frequencias, Jornada $jornada, $day, $month, $year, $week, &$totalSaldoMinutos)
    {
        $dayData = $frequencias->get($date->format('Y-m-d'));
        $diaDaSemana = strtolower($date->isoFormat('dddd'));
        $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
        $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

        $horasTrabalhadas = 0;
        $status = "Não compareceu";
        $batidas = ['-', '-', '-', '-'];

        if ($dayData) {
            $sortedBatidas = $dayData->sortBy('ponto')->values();
            $batidas = $this->getBatidas($sortedBatidas);
            list($horasTrabalhadas, $status) = $this->calculateWorkedHours($sortedBatidas, $batidas);
        }

        $saldoMinutos = $this->calculateBalance($horasTrabalhadas, $horasPrevistasEmMinutos, $status);
        $totalSaldoMinutos += $saldoMinutos;

        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => $batidas[0],
            'Início do intervalo' => $batidas[1],
            'Fim do intervalo' => $batidas[2],
            'Fim da jornada' => $batidas[3],
            'Status' => $status,
            'Saldo' => $this->formatSaldo($saldoMinutos),
            'Totalizador' => ''
        ];
    }

    protected function getBatidas($sortedBatidas)
    {
        return [
            isset($sortedBatidas[0]) ? Carbon::parse($sortedBatidas[0]->ponto)->format('H:i') : '-',
            isset($sortedBatidas[1]) ? Carbon::parse($sortedBatidas[1]->ponto)->format('H:i') : '-',
            isset($sortedBatidas[2]) ? Carbon::parse($sortedBatidas[2]->ponto)->format('H:i') : '-',
            isset($sortedBatidas[3]) ? Carbon::parse($sortedBatidas[3]->ponto)->format('H:i') : '-'
        ];
    }

    protected function calculateWorkedHours($sortedBatidas, $batidas)
    {
        $numBatidas = count($sortedBatidas);
        $horasTrabalhadas = 0;
        $status = "Não compareceu";

        if ($numBatidas === 4) {
            $horasTrabalhadas = Carbon::parse($batidas[3])->diffInMinutes(Carbon::parse($batidas[0])) 
                               - Carbon::parse($batidas[2])->diffInMinutes(Carbon::parse($batidas[1]));
            $status = "Compareceu";
        } elseif ($numBatidas > 0) {
            $status = "Incompleto";
            if ($batidas[0] != '-' && $batidas[3] != '-') {
                $horasTrabalhadas = Carbon::parse($batidas[3])->diffInMinutes(Carbon::parse($batidas[0]));
            } elseif ($batidas[0] != '-') {
                $horasTrabalhadas = Carbon::parse($batidas[0])->diffInMinutes(Carbon::now());
            }
        }

        return [$horasTrabalhadas, $status];
    }

    protected function calculateBalance($horasTrabalhadas, $horasPrevistasEmMinutos, $status)
    {
        if ($status === "Não compareceu" || $status === "Incompleto") {
            return -$horasPrevistasEmMinutos + $horasTrabalhadas;
        }
        return $horasTrabalhadas - $horasPrevistasEmMinutos;
    }

    protected function formatSaldo($saldoMinutos)
    {
        $absSaldo = abs($saldoMinutos);
        $formatted = sprintf('%02d:%02d', intdiv($absSaldo, 60), $absSaldo % 60);
        return $saldoMinutos < 0 ? "-{$formatted}" : $formatted;
    }

    protected function addTotalRow(&$data, $totalSaldoMinutos)
    {
        $horas = intdiv(abs($totalSaldoMinutos), 60);
        $minutos = abs($totalSaldoMinutos) % 60;
        $total = sprintf('%02d:%02d', $horas, $minutos);
        $total = $totalSaldoMinutos < 0 ? "-{$total}" : $total;

        $data->push([
            'Dia' => '', 'Mês' => '', 'Ano' => '', 'Semana' => '',
            'Início da jornada' => '', 'Início do intervalo' => '',
            'Fim do intervalo' => '', 'Fim da jornada' => '',
            'Status' => 'Total', 'Saldo' => '', 'Totalizador' => $total
        ]);
    }

    public function headings(): array
    {
        return [
            'Dia', 'Mês', 'Ano', 'Semana',
            'Início da jornada', 'Início do intervalo',
            'Fim do intervalo', 'Fim da jornada',
            'Status', 'Saldo', 'Totalizador'
        ];
    }
}