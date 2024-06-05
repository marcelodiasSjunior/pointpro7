<?php

use App\Http\Controllers\Company\AtividadesController;
use App\Http\Controllers\Company\AvaliacaoController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\FeedbackController;
use App\Http\Controllers\Company\FrequenciaController;
use App\Http\Controllers\Company\FuncionariosController;
use App\Http\Controllers\Company\FuncoesController;
use App\Http\Controllers\Company\JornadasController;
use App\Http\Controllers\Company\ObservacoesController;
use App\Http\Controllers\CompanyDashboardController;
use Illuminate\Support\Facades\Route;

\URL::forceScheme('https');

// Dashboard routes
Route::get('/', [CompanyDashboardController::class, 'home']);
Route::get('/qrcode', [CompanyDashboardController::class, 'qrcode']);

Route::get('/perfil', [CompanyDashboardController::class, 'perfil']);
Route::post('/perfil', [CompanyDashboardController::class, 'perfil_atualizar']);

//Politica de Privacidade
Route::get('/politicaprivacidade', [CompanyDashboardController::class, 'politicaprivacidade']);
//Termos de uso
Route::get('/termosdeuso', [CompanyDashboardController::class, 'termosdeuso']);

// Company Routes
Route::get('/onboarding', [FuncoesController::class, 'index']);
Route::post('/onboarding', [CompanyController::class, 'onboarding_save']);
Route::post('/atualizar-empresa', [CompanyController::class, 'update_company']);
Route::get('/empresa', [CompanyController::class, 'index']);
Route::get('/assinatura', [CompanyController::class, 'assinatura']);

// Funcoes Routes
Route::get('/funcoes', [FuncoesController::class, 'index']);
Route::get('/funcoes/{id}/deletar', [FuncoesController::class, 'delete']);
Route::get('/funcoes/adicionar-nova', [FuncoesController::class, 'create']);
Route::post('/funcoes/adicionar-nova', [FuncoesController::class, 'save']);
Route::get('/funcoes/{id}/editar', [FuncoesController::class, 'edit']);
Route::post('/funcoes/{id}/editar', [FuncoesController::class, 'update']);

// Jornadas Routes
Route::get('/jornadas', [JornadasController::class, 'index']);
Route::get('/jornadas/{id}/deletar', [JornadasController::class, 'delete']);
Route::get('/jornadas/adicionar-nova', [JornadasController::class, 'create']);
Route::post('/jornadas/adicionar-nova', [JornadasController::class, 'save']);
Route::get('/jornadas/{id}/editar', [JornadasController::class, 'edit']);
Route::post('/jornadas/{id}/editar', [JornadasController::class, 'update']);

//Funcionarios Routes
Route::get('/funcionarios', [FuncionariosController::class, 'index']);
Route::get('/funcionarios/{id}/ver', [FuncionariosController::class, 'ver']);
Route::get('/funcionarios/{id}/deletar', [FuncionariosController::class, 'delete']);
Route::get('/funcionarios/adicionar-novo', [FuncionariosController::class, 'create']);
Route::post('/funcionarios/adicionar-novo', [FuncionariosController::class, 'save']);
Route::get('/funcionarios/{id}/editar', [FuncionariosController::class, 'edit']);
Route::post('/funcionarios/{id}/editar', [FuncionariosController::class, 'update']);
Route::get('/funcionarios/exportPDF', [FuncionariosController::class, 'exportPDF']);
Route::get('/funcionarios/exportXLS', [FuncionariosController::class, 'exportXLS']);


//Atividades Routes
Route::get('/atividades', [AtividadesController::class, 'listar']);
Route::get('/atividades/funcao/{id}', [AtividadesController::class, 'listar_por_funcao']);
Route::get('/atividades/funcionario/{id}', [AtividadesController::class, 'listar_por_funcionario']);
Route::get('/atividades/funcionario/todas/{id}', [AtividadesController::class, 'listar_por_funcionario_todas']);
Route::post('/atividades/funcionario/{id}/{atividade_id}/atualizar', [AtividadesController::class, 'atualizar']);
Route::post('/atividades/funcionario/{id}/{atividade_id}/criar', [AtividadesController::class, 'criar']);


Route::get('/atividades/adicionar-nova', [AtividadesController::class, 'create']);
Route::post('/atividades/adicionar-nova', [AtividadesController::class, 'save']);
Route::get('/atividades/editar/{id}', [AtividadesController::class, 'edit']);
Route::post('/atividades/editar/{id}', [AtividadesController::class, 'update']);
Route::get('/atividades/apagar/{id}/{id2}', [AtividadesController::class, 'delete']);


// Observacoes Routes
Route::get('/observacoes', [ObservacoesController::class, 'listar']);
Route::get('/observacoes/{id}/{id2}', [ObservacoesController::class, 'edit']);
Route::post('/observacoes/{id}/{id2}', [ObservacoesController::class, 'send_message']);

// Frequencia Routes
Route::get('/frequencia', [FrequenciaController::class, 'listar']);
Route::get('/frequencia/{id}', [FrequenciaController::class, 'funcionario']);
Route::get('/frequencia/{id}/export-pdf/{ano}/{mes}', [FrequenciaController::class, 'exportPdf']);
Route::get('/frequencia/{id}/edit', [FrequenciaController::class, 'edit'])->name('frequencias.edit');
Route::put('/frequencia/{id}', [FrequenciaController::class, 'update'])->name('frequencias.update');

Route::get('/politicaprivacidade', function () {
    return view('pages.company.politicaprivacidade');
});

Route::get('/termosdeuso', function () {
    return view('pages.company.termosdeuso');
});

Route::get('/manual', function () {
    return view('pages.company.manual');
});

Route::get('/suporte', function () {
    return view('pages.company.suporte');
});

// Feedback Routes
Route::get('/feedback/funcionario/{id}', [FeedbackController::class, 'listar']);
Route::post('/feedback/funcionario/{id}', [FeedbackController::class, 'send_message']);

// Avaliações Routes
Route::get('/avaliacoes/funcionario/{id}', [AvaliacaoController::class, 'funcionario']);
Route::post('/avaliacoes/funcionario/{id}', [AvaliacaoController::class, 'send_avaliacao']);
