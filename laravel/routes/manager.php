<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EmpresasController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

\URL::forceScheme('https');

Route::get('/', [AdminDashboardController::class, 'home']);
Route::get('/empresas', [EmpresasController::class, 'list']);
Route::get('/empresas/cadastrar', [EmpresasController::class, 'create']);
Route::post('/empresas/cadastrar', [EmpresasController::class, 'save']);
Route::get('/empresas/editar/{id}', [EmpresasController::class, 'edit']);
Route::post('/empresas/editar/{id}', [EmpresasController::class, 'update']);

Route::get('/usuarios', [UsersController::class, 'list']);
Route::get('/usuarios/cadastrar', [UsersController::class, 'create']);
Route::post('/usuarios/cadastrar', [UsersController::class, 'save']);
Route::get('/usuarios/editar/{id}', [UsersController::class, 'edit']);
Route::post('/usuarios/editar/{id}', [UsersController::class, 'update']);
