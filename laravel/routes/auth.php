<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/recuperar-senha', [AuthController::class, 'recuperar_senha']);
Route::post('/enviar-codigo-recuperacao', [AuthController::class, 'enviar_codigo_recuperacao']);
Route::get('/atualizar-senha/{token}', [AuthController::class, 'atualizar_senha'])->name('password.reset');
Route::post('/salva-nova-senha', [AuthController::class, 'salvar_nova_senha']);
