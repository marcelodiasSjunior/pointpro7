<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Worker\AtividadesController;
use App\Http\Controllers\Api\Worker\HomeController;
use App\Http\Controllers\Api\Worker\PresencaController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WoocommerceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

\URL::forceScheme('https');

Route::post('/woocommerce_membership_created', [WoocommerceController::class, 'membership_created']);
Route::post('/woocommerce_membership_updated',  [WoocommerceController::class, 'membership_updated']);
Route::post('/woocommerce_membership_deleted',  [WoocommerceController::class, 'membership_deleted']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cities/{id}', [CommonController::class, 'cities']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-picture', [UploadController::class, 'picture']);
    Route::post('/upload-pdf', [UploadController::class, 'pdf']);
});


Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [AuthController::class, 'user']);
});


Route::middleware('auth:sanctum')->prefix('funcionario')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/atividades', [AtividadesController::class, 'index']);
    Route::get('/presenca', [PresencaController::class, 'index']);
    Route::post('/atividades/{funcionario_atividade_id}/atualizar', [AtividadesController::class, 'atualizar']);
    Route::post('/atividades/{atividade_funcionario_id}/criar', [AtividadesController::class, 'criar']);
});
