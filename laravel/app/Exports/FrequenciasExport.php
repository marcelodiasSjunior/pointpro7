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

    // Método `collection` da classe `FrequenciasExport`

    // Método `collection` da classe `FrequenciasExport`

    public function collection()
    {
        $startDate = Carbon::parse("{$this->ano}-{$this->mes}-01");
        $endDate = Carbon::parse("{$this->ano}-{$this->mes}-01")->endOfMonth();
        $today = Carbon::now()->startOfDay();
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

        $data = $allDays->map(function ($date) use ($frequencias, $jornada, &$totalSaldoMinutos, $today) {
            $day = $date->format('d/m/Y');
            $month = $date->translatedFormat('F');
            $year = $date->format('Y');
            $week = $date->translatedFormat('l');

            if ($date->gt($today)) {
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

            // Verifica se o dia está coberto por algum atestado
            $atestadoCobreDia = $this->atestados->contains(function ($atestado) use ($date) {
                $start = Carbon::parse($atestado->startDate)->startOfDay();
                $end = Carbon::parse($atestado->endDate)->endOfDay();
                return $date->between($start, $end);
            });

            if ($atestadoCobreDia) {
                $diaDaSemana = strtolower($date->isoFormat('dddd'));
                $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
                $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

                // Considera as horas previstas como cumpridas
                $saldoMinutos = 0;
                $totalSaldoMinutos += $saldoMinutos;
                $saldoFormatado = '00:00';

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
                    'Saldo' => $saldoFormatado,
                    'Totalizador' => ''
                ];
            }

            $dayData = $frequencias->get($date->format('Y-m-d'));

            $diaDaSemana = strtolower($date->isoFormat('dddd'));
            $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
            $horasPrevistasEmMinutos = is_numeric($horasPrevistas) ? $horasPrevistas * 60 : 0;

            $horasTrabalhadas = 0;
            $status = "Não compareceu";

            $inicioJornada = '-';
            $inicioIntervalo = '-';
            $fimIntervalo = '-';
            $fimJornada = '-';

            if ($dayData) {
                $sortedBatidas = $dayData->sortBy('ponto')->values();
                $numBatidas = count($sortedBatidas);

                $inicioJornada = isset($sortedBatidas[0]) ? Carbon::parse($sortedBatidas[0]->ponto)->format('H:i') : '-';
                $inicioIntervalo = isset($sortedBatidas[1]) ? Carbon::parse($sortedBatidas[1]->ponto)->format('H:i') : '-';
                $fimIntervalo = isset($sortedBatidas[2]) ? Carbon::parse($sortedBatidas[2]->ponto)->format('H:i') : '-';
                $fimJornada = isset($sortedBatidas[3]) ? Carbon::parse($sortedBatidas[3]->ponto)->format('H:i') : '-';

                if ($numBatidas === 4) {
                    $horasTrabalhadas = Carbon::parse($fimJornada)->diffInMinutes(Carbon::parse($inicioJornada)) - Carbon::parse($fimIntervalo)->diffInMinutes(Carbon::parse($inicioIntervalo));
                    $status = "Compareceu";
                } elseif ($numBatidas < 4 && $numBatidas > 0) {
                    $status = "Incompleto";
                    if ($inicioJornada != '-' && $fimJornada != '-') {
                        $horasTrabalhadas = Carbon::parse($fimJornada)->diffInMinutes(Carbon::parse($inicioJornada));
                    } elseif ($inicioJornada != '-' && $fimJornada == '-') {
                        $horasTrabalhadas = Carbon::parse($inicioJornada)->diffInMinutes(Carbon::now());
                    }
                }
            }

            if ($status === "Não compareceu" || $status === "Incompleto") {
                $saldoMinutos = -$horasPrevistasEmMinutos + $horasTrabalhadas;
                $totalSaldoMinutos += $saldoMinutos;
                $saldoFormatado = sprintf('%02d:%02d', intdiv(abs($saldoMinutos), 60), abs($saldoMinutos) % 60);
                $saldoFormatado = $saldoMinutos < 0 ? "-$saldoFormatado" : $saldoFormatado;
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
                    'Totalizador' => ''
                ];
            }

            $saldoMinutos = $horasTrabalhadas - $horasPrevistasEmMinutos;
            $totalSaldoMinutos += $saldoMinutos;
            $saldoFormatado = sprintf('%02d:%02d', intdiv(abs($saldoMinutos), 60), abs($saldoMinutos) % 60);
            $saldoFormatado = $saldoMinutos < 0 ? "-$saldoFormatado" : $saldoFormatado;

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
                'Totalizador' => ''
            ];
        });

        $horasTotalSaldo = intdiv($totalSaldoMinutos, 60);
        $minutosTotalSaldo = abs($totalSaldoMinutos) % 60;
        $totalSaldoFormatado = sprintf('%02d:%02d', $horasTotalSaldo, $minutosTotalSaldo);
        $totalSaldoFormatado = $totalSaldoMinutos < 0 ? "-$totalSaldoFormatado" : $totalSaldoFormatado;

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
            'Totalizador' // Adiciona o cabeçalho do totalizador aqui
        ];
    }
}
