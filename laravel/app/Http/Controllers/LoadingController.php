<?php

namespace App\Http\Controllers;

use App\Http\Services\DomainService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoadingController extends Controller
{
    public function  index()
    {
        $user = Auth::user();

        if (!$user) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.auth')));
        }
        if ($user->role === 1) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.manager')));
        } else if ($user->role === 2) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.painel')));
        } else if ($user->role === 3) {
            return Redirect::to(DomainService::getFullHost(config('app.sudomains.funcionario')));
        }
    }
}
