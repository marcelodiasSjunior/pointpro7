<?php

namespace App\Http\Controllers;

use App\Http\Services\CityService;

class CommonController extends Controller
{
    public function cities($state_id)
    {
        $cities = CityService::getCities($state_id);

        return $cities;
    }
}
