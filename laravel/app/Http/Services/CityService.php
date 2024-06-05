<?php

namespace App\Http\Services;

class CityService
{
    static function getStates()
    {
        $arrNewSku = array();
        $incI = 0;
        foreach (CitiesAndStates::getStates() as $arrKey => $arrData) {
            $arrNewSku[$incI]['id'] = $arrData['id'];
            $arrNewSku[$incI]['name'] = $arrData['name'];
            $arrNewSku[$incI]['abbr'] = $arrData['abbr'];
            $incI++;
        }

        return $arrNewSku;
    }

    static function getCities($state_id)
    {
        $array = array_filter(CitiesAndStates::getCities(), function ($v, $k) use ($state_id) {
            return $v['state_id'] == $state_id;
        }, ARRAY_FILTER_USE_BOTH);

        $arrNewSku = array();
        $incI = 0;
        foreach ($array as $arrKey => $arrData) {
            $arrNewSku[$incI]['id'] = $arrData['id'];
            $arrNewSku[$incI]['name'] = $arrData['name'];
            $arrNewSku[$incI]['state_id'] = $arrData['state_id'];
            $incI++;
        }
        return $arrNewSku;
    }

    static function getState($id)
    {
        $result = array_filter(CitiesAndStates::getStates(), function ($v, $k) use ($id) {
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

    static function getStateByName($name)
    {
        $result = array_filter(CitiesAndStates::getStates(), function ($v, $k) use ($name) {
            return $v['name'] == $name;
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

    static function getCityByName($name)
    {
        $result = array_filter(CitiesAndStates::getCities(), function ($v, $k) use ($name) {
            return $v['name'] == $name;
        }, ARRAY_FILTER_USE_BOTH);

        if (count($result) > 0) {
            $arrNewSku = array();
            $incI = 0;
            foreach ($result as $arrKey => $arrData) {
                $arrNewSku[$incI]['id'] = $arrData['id'];
                $arrNewSku[$incI]['state_id'] = $arrData['state_id'];
                $arrNewSku[$incI]['name'] = $arrData['name'];
                $incI++;
            }
            return $arrNewSku[0];
        }

        return false;
    }

    static function getCity($id)
    {
        $result = array_filter(CitiesAndStates::getCities(), function ($v, $k) use ($id) {
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
}
