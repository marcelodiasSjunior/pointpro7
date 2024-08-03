<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function home()
    {
        $data = [
            'company_count' => Company::count(),
            'user_count' => User::where('role', 2)->count()
        ];
        return view('pages.admin.home', $data);
    }
}
