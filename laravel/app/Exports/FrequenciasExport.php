<?php

namespace App\Exports;

use App\Models\Frequencia;
use App\Models\Funcionario;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FrequenciasExport implements FromCollection, WithHeadings
{
    protected $company_id;
    protected $funcionario_id;
    protected $ano;
    protected $mes;

    public function __construct($company_id, $funcionario_id, $ano, $mes)
    {
        $this->company_id = $company_id;
        $this->funcionario_id = $funcionario_id;
        $this->ano = $ano;
        $this->mes = $mes;
    }

    public function collection()
    {
        $startDate = Carbon::parse("{$this->ano}-{$this->mes}-01");
        $endDate = $startDate->copy()->endOfMonth();
        $allDays = $this->generateAllDays($startDate, $endDate);
        $totalSaldoMinutos = 0;

        $frequencias = $this->getFrequencias($startDate, $endDate);
        $funcionario = $this->getFuncionario();
        $jornada = $funcionario->jornada;

        $data = $allDays->map(function ($date) use ($frequencias, $jornada, &$totalSaldoMinutos) {
            return $this->processDayData($date, $frequencias, $jornada, $totalSaldoMinutos);
        });

        $this->addTotalSaldoRow($data);

        return collect($data);
    }

    protected function generateAllDays(Carbon $startDate, Carbon $endDate)
    {
        $allDays = collect();
        while ($startDate->lte($endDate)) {
            $allDays->push($startDate->copy());
            $startDate->addDay();
        }
        return $allDays;
    }

    protected function getFrequencias(Carbon $startDate, Carbon $endDate)
    {
        return Frequencia::where('company_id', $this->company_id)
            ->where('funcionario_id', $this->funcionario_id)
            ->whereBetween('ponto', ["{$startDate->format('Y-m-d')} 00:00:00", "{$endDate->format('Y-m-d')} 23:59:59"])
            ->orderBy('ponto')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->ponto)->format('Y-m-d');
            });
    }

    protected function getFuncionario()
    {
        return Funcionario::where('id', $this->funcionario_id)
            ->where('company_id', $this->company_id)
            ->first();
    }

    protected function processDayData(Carbon $date, $frequencias, $jornada, &$totalSaldoMinutos)
    {
        $day = $date->format('d/m/Y');
        $month = $date->translatedFormat('F');
        $year = $date->format('Y');
        $week = $date->translatedFormat('l');
        $dayData = $frequencias->get($date->format('Y-m-d'));

        $diaDaSemana = strtolower($date->isoFormat('dddd'));
        $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
        $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

        if ($dayData) {
            return $this->processDayWithData($dayData, $day, $month, $year, $week, $horasPrevistas, $totalSaldoMinutos);
        } else {
            $saldoMinutos = $date->isPast() ? -$horasPrevistasEmMinutos : 0;
            return $this->processDayWithoutData($day, $month, $year, $week, $saldoMinutos, $totalSaldoMinutos);
        }
    }

    protected function processDayWithData($dayData, $day, $month, $year, $week, $horasPrevistas, &$totalSaldoMinutos)
    {
        $sortedBatidas = $dayData->sortBy('ponto')->values();
        $inicioJornada = $this->formatTime($sortedBatidas, 0);
        $inicioIntervalo = $this->formatTime($sortedBatidas, 1);
        $fimIntervalo = $this->formatTime($sortedBatidas, 2);
        $fimJornada = $this->formatTime($sortedBatidas, count($sortedBatidas) - 1);

        $horasTrabalhadas = $this->calculateHorasTrabalhadas($sortedBatidas);
        $horasTrabalhadas -= $this->calculateIntervalo($sortedBatidas);

        $saldoMinutos = $this->calculateSaldoMinutos($horasTrabalhadas, $horasPrevistas);
        $totalSaldoMinutos += $saldoMinutos;

        $saldoFormatado = $this->formatSaldo($saldoMinutos);
        $status = $this->determineStatus($inicioJornada, $inicioIntervalo, $fimIntervalo, $fimJornada);

        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => $inicioJornada,
            'Início do intervalo' => $inicioIntervalo,
            'Fim do intervalo' => $fimIntervalo,
            'Fim da jornada' => $fimJornada,
            'Status' => $status,
            'Saldo' => $saldoFormatado,
            'SaldoMinutos' => $saldoMinutos,
            'Totalizador' => ''
        ];
    }

    protected function processDayWithoutData($day, $month, $year, $week, $saldoMinutos, &$totalSaldoMinutos)
    {
        $totalSaldoMinutos += $saldoMinutos;
        $saldoFormatado = $this->formatSaldo($saldoMinutos);

        return [
            'Dia' => $day,
            'Mês' => $month,
            'Ano' => $year,
            'Semana' => $week,
            'Início da jornada' => '-',
            'Início do intervalo' => '-',
            'Fim do intervalo' => '-',
            'Fim da jornada' => '-',
            'Status' => 'Não compareceu',
            'Saldo' => $saldoFormatado,
            'SaldoMinutos' => $saldoMinutos,
            'Totalizador' => ''
        ];
    }

    protected function addTotalSaldoRow(&$data)
    {
        $totalSaldoMinutos = $data->reduce(function ($carry, $item) {
            return $carry + $item['SaldoMinutos'];
        }, 0);

        $horasTotalSaldo = intdiv($totalSaldoMinutos, 60);
        $minutosTotalSaldo = abs($totalSaldoMinutos) % 60;
        $totalSaldoFormatado = sprintf('%02d:%02d', abs($horasTotalSaldo), abs($minutosTotalSaldo));

        $data->push([
            'Dia' => '',
            'Mês' => '',
            'Ano' => '',
            'Semana' => '',
            'Início da jornada' => '',
            'Início do intervalo' => '',
            'Fim do intervalo' => '',
            'Fim da jornada' => '',
            'Status' => 'Total',
            'Saldo' => '',
            'Totalizador' => ($totalSaldoMinutos < 0 ? '-' : '') . $totalSaldoFormatado
        ]);
    }

    protected function formatTime($sortedBatidas, $index)
    {
        return isset($sortedBatidas[$index]) ? Carbon::parse($sortedBatidas[$index]->ponto)->format('H:i') : '-';
    }

    protected function calculateHorasTrabalhadas($sortedBatidas)
    {
        if (count($sortedBatidas) >= 2) {
            $inicioJornadaTime = Carbon::parse($sortedBatidas[0]->ponto);
            $fimJornadaTime = Carbon::parse(end($sortedBatidas)->ponto);
            return $fimJornadaTime->diffInMinutes($inicioJornadaTime);
        }
        return 0;
    }

    protected function calculateIntervalo($sortedBatidas)
    {
        if (count($sortedBatidas) >= 4) {
            $inicioIntervaloTime = Carbon::parse($sortedBatidas[1]->ponto);
            $fimIntervaloTime = Carbon::parse($sortedBatidas[2]->ponto);
            return $fimIntervaloTime->diffInMinutes($inicioIntervaloTime);
        } elseif (count($sortedBatidas) == 3) {
            $inicioIntervaloTime = Carbon::parse($sortedBatidas[1]->ponto);
            $fimIntervaloTime = Carbon::parse(end($sortedBatidas)->ponto);
            return $fimIntervaloTime->diffInMinutes($inicioIntervaloTime);
        }
        return 0;
    }

    protected function calculateSaldoMinutos($horasTrabalhadas, $horasPrevistas)
    {
        $horasPrevistasEmMinutos = $horasPrevistas * 60;
        return $horasTrabalhadas - $horasPrevistasEmMinutos;
    }

    protected function formatSaldo($saldoMinutos)
    {
        $horasSaldo = intdiv($saldoMinutos, 60);
        $minutosSaldo = abs($saldoMinutos) % 60;
        return sprintf('%02d:%02d', $horasSaldo, $minutosSaldo);
    }

    protected function determineStatus($inicioJornada, $inicioIntervalo, $fimIntervalo, $fimJornada)
    {
        if (!$inicioJornada && !$inicioIntervalo && !$fimIntervalo && !$fimJornada) {
            return "Não compareceu";
        } elseif (!$fimJornada || !$fimIntervalo || !$inicioIntervalo || !$inicioJornada) {
            return "Incompleto";
        }
        return "Compareceu";
    }

    public function headings(): array
    {
        return [
            'Dia',
            'Mês',
            'Ano',
            'Semana',
            'Início da jornada',
            'Início do intervalo',
            'Fim do intervalo',
            'Fim da jornada',
            'Status',
            'Saldo',
            'Totalizador'
        ];
    }
}