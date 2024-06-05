<?php

namespace App\Http\Services;

use Carbon\Carbon;


function getDayString($dayOfTheWeek)
{
    if ($dayOfTheWeek === 1) {
        return 'Domingo';
    }
    if ($dayOfTheWeek === 2) {
        return 'Segunda-feira';
    }
    if ($dayOfTheWeek === 3) {
        return 'Terca-feira';
    }
    if ($dayOfTheWeek === 4) {
        return 'Quarta-feira';
    }
    if ($dayOfTheWeek === 5) {
        return 'Quinta-feira';
    }
    if ($dayOfTheWeek === 6) {
        return 'Sexta-feira';
    }
    if ($dayOfTheWeek === 7) {
        return 'Sabado';
    }
    return '';
}
class CommomDataService
{
    static function createFromDate($date)
    {
        return Carbon::createFromDate($date, 'America/Sao_Paulo');
    }
    static function restApiTokenWeb($req)
    {
        $token = $req->user()->createToken('api_token_for_web');
        return [
            'token' => $token,
            'api_token_for_web' => $token->accessToken->token,
            'plainTextToken' =>  $token->plainTextToken
        ];
    }
    static function getCommonDates($req)
    {
        setlocale(LC_TIME, 'portuguese');
        Carbon::setLocale('pt_BR');

        if ($req->dia && $req->mes && $req->ano) {
            $selectedDate = Carbon::createFromDate($req->ano, $req->mes, $req->dia, 'America/Sao_Paulo')->locale('pt_BR');
        } else if ($req->mes && $req->ano) {
            $selectedDate = Carbon::createFromDate($req->ano, $req->mes, "01", 'America/Sao_Paulo')->locale('pt_BR');
        } else {
            $selectedDate = CommomDataService::getCarbonNow()->locale('pt_BR');
        }

        $days = $selectedDate->diff(Carbon::now()->locale('pt_BR'))->days;
        if ($days < 1) {
            $diffHuman = 'Hoje';
        } else if ($days == 1) {
            $diffHuman = '1 dia atras';
        } else {
            $diffHuman =  $days . ' dias atras';
        }

        $monthList = [
            "01"  => "Janeiro",
            "02"  => "Fevereiro",
            "03"  => "Março",
            "04"  => "Abril",
            "05"  => "Maio",
            "06"  => "Junho",
            "07"  => "Julho",
            "08"  => "Agosto",
            "09"  => "Setembro",
            "10"  => "Outubro",
            "11"  => "Novembro",
            "12"  => "Dezembro"
        ];

        return  [
            "ano" => $selectedDate->year,
            "mes" => $selectedDate->format('m'),
            "dia" => $selectedDate->format('d'),
            "dayOfWeekString" => $selectedDate->locale('pt_BR')->dayName,
            "dayOfTheWeek" => $selectedDate->dayOfWeek + 1,
            "dayOfWeekHuman" => $selectedDate->format('d/m/Y'),
            "dayOfWeekName" => ucfirst($selectedDate->dayName),
            "dayDiffHumans" => $diffHuman,
            "dateForMySQL" => $selectedDate->format('Y-m-d'),
            "localTime" => $selectedDate->format('H:i'),
            "monthNumber" => $selectedDate->month,
            "yearNumber" => $selectedDate->format('Y'),
            "dayNumber" => $selectedDate->format('d'),
            "daysInMonth" => $selectedDate->daysInMonth,
            "yearMin" => 2023,
            "yearMax" => Carbon::now()->format('Y') + 1,
            "monthList" => $monthList,
            "now" => $selectedDate
        ];
    }
    static function  getCarbonNow()
    {
        return Carbon::now('America/Sao_Paulo');
    }
    static function getDayOfWeekString()
    {
        $now = Carbon::now('America/Sao_Paulo');
        $dayOfTheWeek = $now->dayOfWeek + 1;
        return getDayString($dayOfTheWeek);
    }

    static function getDayOfWeekName($data)
    {
        $now = Carbon::createFromDAte($data, 'America/Sao_Paulo');
        $dayOfTheWeek = $now->dayOfWeek + 1;
        return getDayString($dayOfTheWeek);
    }

    static function getDayOfWeekHuman()
    {
        $now = Carbon::now('America/Sao_Paulo');
        return $now->format('d/m/Y');
    }
    static function getEstadoCivil()
    {
        return [
            ['id' => 1, 'name' => 'SOLTEIRO'],
            ['id' => 2, 'name' => 'CASADO'],
            ['id' => 3, 'name' => 'DIVORCIADO'],
            ['id' => 4, 'name' => 'VIÚVO']
        ];
    }


    static function findEstadoCivil($id)
    {
        $data = CommomDataService::getEstadoCivil();
        $result = array_filter($data, function ($v, $k) use ($id) {
            return $v['id'] == $id;
        }, ARRAY_FILTER_USE_BOTH);

        if (count($result) > 0) {
            $arrNewSku = array();
            $incI = 0;
            foreach ($result as $arrKey => $arrData) {
                $arrNewSku[$incI]['id'] = $arrData['id'];
                $arrNewSku[$incI]['name'] = $arrData['name'];
                $incI++;
            }
            return $arrNewSku[0];
        }

        return false;
    }

    static function findGrauInstrucao($id)
    {
        $data = CommomDataService::getGrauInstrucao();
        $result = array_filter($data, function ($v, $k) use ($id) {
            return $v['id'] == $id;
        }, ARRAY_FILTER_USE_BOTH);

        if (count($result) > 0) {
            $arrNewSku = array();
            $incI = 0;
            foreach ($result as $arrKey => $arrData) {
                $arrNewSku[$incI]['id'] = $arrData['id'];
                $arrNewSku[$incI]['name'] = $arrData['name'];
                $incI++;
            }
            return $arrNewSku[0];
        }

        return false;
    }

    static function getGrauInstrucao()
    {
        return [
            ['id' => 1, 'name' => 'ANALFABETO'],
            ['id' => 2, 'name' => 'FUNDAMENTAL INCOMPLETO'],
            ['id' => 3, 'name' => 'FUNDAMENTAL COMPLETO'],
            ['id' => 4, 'name' => 'MÉDIO INCOMPLETO'],
            ['id' => 5, 'name' => 'MÉDIO COMPLETO'],
            ['id' => 6, 'name' => 'SUPERIOR INCOMPLETO'],
            ['id' => 7, 'name' => 'SUPERIOR COMPLETO'],
            ['id' => 8, 'name' => 'ESPECIALIZAÇÃO'],
            ['id' => 9, 'name' => 'MESTRADO'],
            ['id' => 10, 'name' => 'DOUTORADO'],
            ['id' => 11, 'name' => 'PÓS-DOUTORADO'],
        ];
    }

    static function findComorbidades($ids)
    {
        $data = CommomDataService::getComorbidades();
        $all = [];
        $idArrays = explode(",", $ids);

        foreach ($idArrays as $id) {
            $result = array_filter($data, function ($v, $k) use ($id) {
                return $v['id'] == $id;
            }, ARRAY_FILTER_USE_BOTH);

            if (count($result) > 0) {
                $arrNewSku = array();
                $incI = 0;
                foreach ($result as $arrKey => $arrData) {
                    $arrNewSku[$incI]['id'] = $arrData['id'];
                    $arrNewSku[$incI]['name'] = $arrData['name'];
                    $incI++;
                }
                $all[] = $arrNewSku[0];
            }
        }

        return $all;
    }

    static function getComorbidades()
    {
        return [
            ['id' => 1, 'name' => 'NÃO TENHO COMORBIDADES'],
            ['id' => 2, 'name' => 'DIABETES'],
            ['id' => 3, 'name' => 'DOENÇA RENAL CRÔNICA'],
            ['id' => 4, 'name' => 'OBESIDADE MÓRBIDA'],
            ['id' => 5, 'name' => 'HIPERTENSÃO ARTERIALESTÁGIO 3'],
            ['id' => 6, 'name' => 'HIPERTENSÃO ARTERIAL RESISTENTE (HAR)'],
            ['id' => 7, 'name' => 'SÍNDROME DE DOWN'],
            ['id' => 8, 'name' => 'CIRROSE HEPÁTICA'],
            ['id' => 9, 'name' => 'INSUFICIÊNCIA CARDÍACA'],
            ['id' => 10, 'name' => 'CARDIOPATIA HIPERTENSIVA'],
            ['id' => 11, 'name' => 'MIOCARDIOPATIAS E PERICARDIOPATIAS'],
            ['id' => 12, 'name' => 'SÍNDROMES CORONARIANAS'],
            ['id' => 13, 'name' => 'VALVOPATIAS'],
            ['id' => 14, 'name' => 'ESCLEROSE MÚLTIPLA'],
            ['id' => 15, 'name' => 'ARRITMIAS CARDÍACAS'],
            ['id' => 16, 'name' => 'PNEUMOPATIAS CRÔNICAS GRAVES'],
        ];
    }
}
