<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCompanyRequest;
use App\Http\Services\CityService;
use App\Http\Services\DomainService;
use App\Models\Company;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    public function index(Request $req)
    {
        $states = CityService::getStates();
        $company = $req->user()->company;

        return view('pages.company.company', ['states' => $states, 'company' => $company]);
    }

    public function onboarding()
    {
        $states = CityService::getStates();

        $company = '';

        if (Auth::user()->company) {
            $company = Auth::user()->company;
            return view('pages.company.create-company', ['states' => $states, 'company' => $company]);
        }

        return view('pages.company.create-company', ['states' => $states]);
    }

    public function update_company(SaveCompanyRequest $req)
    {
        $company_id = $req->user()->company->id;

        $data = $req->only([
            'title',
            'logo',
            'seguimento',
            'razao_social',
            'cnpj',
            'telefone',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'state_id',
            'city_id'
        ]);

        Company::where([
            'id' => $company_id
        ])->update($data);

        return redirect('/empresa');
    }

    public function onboarding_save(SaveCompanyRequest $req)
    {
        $data = $req->only([
            'title',
            'logo',
            'seguimento',
            'razao_social',
            'cnpj',
            'telefone',
            'cep',
            'endereco',
            'numero',
            'complemento',
            'bairro',
            'state_id',
            'city_id'
        ]);

        $userCompany = UserCompany::where(
            'user_id',
            $req->user()->id
        )->first();

        if (!$userCompany) {
            $company = Company::create($data);
            $company_id = $company->id;
            UserCompany::create([
                'user_id' => $req->user()->id,
                'company_id' => $company->id
            ]);
        } else {
            $company_id = $userCompany->company_id;

            Company::where([
                'id' => $company_id
            ])->update($data);
        }


        return Redirect::to(DomainService::getFullHost(config('app.sudomains.loading')));;
    }

    public function assinatura(Request $req) {
        $company = $req->user()->company;

        return view('pages.company.assinatura', ['company' => $company]);
    }
}
