<?php

namespace App\Exports;

use App\Models\Frequencia;
use App\Models\Funcionario;
use App\Models\Jornada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

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
        $endDate = Carbon::parse("{$this->ano}-{$this->mes}-01")->endOfMonth();
        $allDays = collect();
        $totalSaldoMinutos = 0;

        while ($startDate->lte($endDate)) {
            $allDays->push($startDate->copy());
            $startDate->addDay();
        }

        $frequencias = Frequencia::where('company_id', $this->company_id)
            ->where('funcionario_id', $this->funcionario_id)
            ->whereBetween('ponto', ["{$this->ano}-{$this->mes}-01 00:00:00", "{$this->ano}-{$this->mes}-{$endDate->day} 23:59:59"])
            ->orderBy('ponto')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->ponto)->format('Y-m-d');
            });

        $funcionario = Funcionario::where('id', $this->funcionario_id)
            ->where('company_id', $this->company_id)
            ->first();

        $jornada = $funcionario->jornada;

        $data = $allDays->map(function ($date) use ($frequencias, $jornada, &$totalSaldoMinutos) {
            $day = $date->format('d/m/Y');
            $month = $date->translatedFormat('F');
            $year = $date->format('Y');
            $week = $date->translatedFormat('l');
            $dayData = $frequencias->get($date->format('Y-m-d'));

            $diaDaSemana = strtolower($date->isoFormat('dddd'));
            $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
            $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

            if ($dayData) {
                $sortedBatidas = $dayData->sortBy('ponto')->values();
                $inicioJornada = isset($sortedBatidas[0]) ? Carbon::parse($sortedBatidas[0]->ponto) : null;
                $inicioIntervalo = isset($sortedBatidas[1]) ? Carbon::parse($sortedBatidas[1]->ponto) : null;
                $fimIntervalo = isset($sortedBatidas[2]) ? Carbon::parse($sortedBatidas[2]->ponto) : null;
                $fimJornada = isset($sortedBatidas[3]) ? Carbon::parse($sortedBatidas[3]->ponto) : null;

                $horasTrabalhadas = 0;
                if ($inicioJornada && $fimJornada) {
                    $horasTrabalhadas = $fimJornada->diffInMinutes($inicioJornada);

                    if ($inicioIntervalo && $fimIntervalo) {
                        $intervalo = $fimIntervalo->diffInMinutes($inicioIntervalo);
                        $horasTrabalhadas -= $intervalo;
                    }
                }

                $saldoMinutos = $horasTrabalhadas - $horasPrevistasEmMinutos;
                $totalSaldoMinutos += $saldoMinutos;

                $saldoFormatado = sprintf('%02d:%02d', intdiv(abs($saldoMinutos), 60), abs($saldoMinutos) % 60);
                if ($saldoMinutos < 0) {
                    $saldoFormatado = "-$saldoFormatado";
                }

                $status = "Compareceu";
                if (!$inicioJornada && !$inicioIntervalo && !$fimIntervalo && !$fimJornada) {
                    $status = "Não compareceu";
                } elseif (!$fimJornada || !$fimIntervalo || !$inicioIntervalo || !$inicioJornada) {
                    $status = "Incompleto";
                }

                return [
                    'Dia' => $day,
                    'Mês' => $month,
                    'Ano' => $year,
                    'Semana' => $week,
                    'Início da jornada' => $inicioJornada ? $inicioJornada->format('H:i') : '-',
                    'Início do intervalo' => $inicioIntervalo ? $inicioIntervalo->format('H:i') : '-',
                    'Fim do intervalo' => $fimIntervalo ? $fimIntervalo->format('H:i') : '-',
                    'Fim da jornada' => $fimJornada ? $fimJornada->format('H:i') : '-',
                    'Status' => $status,
                    'Saldo' => $saldoFormatado,
                    'Totalizador' => ''
                ];
            } else {
                $saldoMinutos = $date->isPast() ? -$horasPrevistasEmMinutos : 0;
                $totalSaldoMinutos += $saldoMinutos;

                $saldoFormatado = sprintf('%02d:%02d', intdiv(abs($saldoMinutos), 60), abs($saldoMinutos) % 60);
                if ($saldoMinutos < 0) {
                    $saldoFormatado = "-$saldoFormatado";
                }

                // Log de depuração
                error_log("Data: $day, Saldo Minutos: $saldoMinutos, Total Saldo Minutos: $totalSaldoMinutos");

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
                    'Totalizador' => ''
                ];
            }
        });

        $horasTotalSaldo = intdiv($totalSaldoMinutos, 60);
        $minutosTotalSaldo = abs($totalSaldoMinutos) % 60;
        $totalSaldoFormatado = sprintf('%02d:%02d', $horasTotalSaldo, $minutosTotalSaldo);
        if ($totalSaldoMinutos < 0) {
            $totalSaldoFormatado = "-$totalSaldoFormatado";
        }

        // Log de depuração
        error_log("Total Saldo Minutos: $totalSaldoMinutos, Total Saldo Formatado: $totalSaldoFormatado");

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
            'Totalizador' => $totalSaldoFormatado
        ]);

        return $data;
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