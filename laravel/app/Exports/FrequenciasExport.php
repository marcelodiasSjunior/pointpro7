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

    public function collection() {
        $startDate = Carbon::parse("{$this->ano}-{$this->mes}-01");
        $endDate = Carbon::parse("{$this->ano}-{$this->mes}-01")->endOfMonth();
        $allDays = collect();

        while ($startDate->lte($endDate)) {
            $allDays->push($startDate->copy());
            $startDate->addDay();
        }

        $frequencias = Frequencia::where('company_id', $this->company_id)
            ->where('funcionario_id', $this->funcionario_id)
            ->whereBetween('ponto', ["{$this->ano}-{$this->mes}-01 00:00:00", "{$this->ano}-{$this->mes}-{$endDate->day} 23:59:59"])
            ->orderBy('ponto')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->ponto)->format('Y-m-d');
            });

        $funcionario = Funcionario::where('id', $this->funcionario_id)
            ->where('company_id', $this->company_id)
            ->first();

        $jornada = $funcionario->jornada;
        $funcionarioUser = $funcionario->user;

        $data = $allDays->map(function ($date) use ($frequencias, $funcionarioUser, $jornada) {
            $day = $date->format('d/m/Y');
            $month = $date->translatedFormat('F'); // Nome do mês em português
            $year = $date->format('Y');
            $week = $date->translatedFormat('l'); // Nome do dia da semana em português
            $dayData = $frequencias->get($date->format('Y-m-d'));

            $diaDaSemana = strtolower($date->isoFormat('dddd')); // traduzido para português
            $horasPrevistas = $jornada->getHorasDia($diaDaSemana);
            $horasPrevistas = is_numeric($horasPrevistas) ? $horasPrevistas : 0;

            if ($dayData) {
                $sortedBatidas = $dayData->sortBy('ponto')->values();
                $inicioJornada = isset($sortedBatidas[0]) ? Carbon::parse($sortedBatidas[0]->ponto)->format('H:i') : '-';
                $inicioIntervalo = isset($sortedBatidas[1]) ? Carbon::parse($sortedBatidas[1]->ponto)->format('H:i') : '-';
                $fimIntervalo = isset($sortedBatidas[2]) ? Carbon::parse($sortedBatidas[2]->ponto)->format('H:i') : '-';
                $fimJornada = isset($sortedBatidas[3]) ? Carbon::parse($sortedBatidas[3]->ponto)->format('H:i') : '-';

                $horasTrabalhadas = 0;
                if (isset($sortedBatidas[0]) && isset($sortedBatidas[3])) {
                    $inicioJornadaTime = Carbon::parse($sortedBatidas[0]->ponto);
                    $fimJornadaTime = Carbon::parse($sortedBatidas[3]->ponto);
                    $horasTrabalhadas = $fimJornadaTime->diffInMinutes($inicioJornadaTime);

                    if (isset($sortedBatidas[1]) && isset($sortedBatidas[2])) {
                        $inicioIntervaloTime = Carbon::parse($sortedBatidas[1]->ponto);
                        $fimIntervaloTime = Carbon::parse($sortedBatidas[2]->ponto);
                        $intervalo = $fimIntervaloTime->diffInMinutes($inicioIntervaloTime);
                        $horasTrabalhadas -= $intervalo;
                    }
                }

                $horasPrevistasEmMinutos = $horasPrevistas * 60;
                $saldoMinutos = $horasTrabalhadas - $horasPrevistasEmMinutos;

                $horasSaldo = intdiv(abs($saldoMinutos), 60);
                $minutosSaldo = abs($saldoMinutos) % 60;
                $saldoFormatado = sprintf('%s%02d:%02d', $saldoMinutos < 0 ? '-' : '', $horasSaldo, $minutosSaldo);

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
                    'Início da jornada' => $inicioJornada,
                    'Início do intervalo' => $inicioIntervalo,
                    'Fim do intervalo' => $fimIntervalo,
                    'Fim da jornada' => $fimJornada,
                    'Status' => $status,
                    'Saldo' => $saldoFormatado
                ];
            } else {
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
                    'Saldo' => '00:00'
                ];
            }
        });

        return collect($data);
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
            'Saldo'
        ];
    }
}
