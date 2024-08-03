<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Services\CommomDataService;
use Illuminate\Http\Request;

class  OnboardingController extends Controller
{
    public function onboarding(Request $req)
    {
        $data = [
            ...CommomDataService::restApiTokenWeb($req)
        ];

        return view('pages.worker.onboarding', $data);
    }
}
