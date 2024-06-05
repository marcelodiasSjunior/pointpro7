<?php

use App\Http\Controllers\Worker\FeedbackController;
use App\Http\Controllers\Worker\FrequenciaController;
use App\Http\Controllers\Worker\AtividadesController;
use App\Http\Controllers\Worker\ObservacoesController;
use App\Http\Controllers\Worker\OnboardingController;
use App\Http\Controllers\Worker\WorkerDashboardController;
use Illuminate\Support\Facades\Route;

\URL::forceScheme('https');

Route::get('/', [WorkerDashboardController::class, 'home']);
Route::get('/perfil', [WorkerDashboardController::class, 'perfil']);
Route::post('/perfil', [WorkerDashboardController::class, 'perfil_atualizar']);

Route::get('/nova-biometria', [WorkerDashboardController::class, 'novaBiometria']);

//Politica de Privacidade 
Route::get('/politicaprivacidade', [WorkerDashboardController::class, 'politicaprivacidade']);
//Termos de uso
Route::get('/termosdeuso', [WorkerDashboardController::class, 'termosdeuso']);

//Manual de uso
Route::get('/manual', [WorkerDashboardController::class, 'manualuso']);

// Onboarding routes
Route::get('/onboarding', [OnboardingController::class, 'onboarding']);

// Observacoes Routes
Route::get('/observacoes', [ObservacoesController::class, 'listar']);
Route::get('/observacoes/{id}', [ObservacoesController::class, 'edit']);
Route::post('/observacoes/{id}', [ObservacoesController::class, 'send_message']);

//Feedback Routes
Route::get('/feedback', [FeedbackController::class, 'listar']);
Route::post('/feedback/{id}', [FeedbackController::class, 'send_message']);


//Atividades Routes
Route::get('/atividades', [AtividadesController::class, 'listar']);
Route::post('/atividades/{funcionario_atividade_id}/atualizar', [AtividadesController::class, 'atualizar']);
Route::post('/atividades/{atividade_funcionario_id}/criar', [AtividadesController::class, 'criar']);

// Frequencia Routes
Route::get('/frequencia', [FrequenciaController::class, 'list']);
Route::get('/frequencia/{id}/export-pdf/{ano}/{mes}', [FrequenciaController::class, 'exportPdf']);

Route::get('/politicaprivacidade', function () {
    return view('pages.worker.politicaprivacidade');
});

Route::get('/termosdeuso', function () {
    return view('pages.worker.termosdeuso');
});