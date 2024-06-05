<?php

use App\Http\Controllers\LoadingController;
use App\Http\Controllers\UploadController;
use App\Models\Funcionario;
use App\Models\WPUser;
use App\Models\WPUserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::domain(config('app.domain'))->group(function () {
    Route::get('/', [LoadingController::class, 'index']);
});


Route::domain('loading.'  .   config('app.domain'))->group(function () {
    Route::get('/', [LoadingController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-picture', [UploadController::class, 'picture']);
    Route::post('/upload-pdf', [UploadController::class, 'pdf']);

    Route::get('/funcionarios_by_funcao/{funcao_id}', function (Request $req, $funcao_id) {
        return Funcionario::with('user')->where('funcao_id', $funcao_id)->where('company_id', $req->user()->company->id)->get();
    });
});

Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

// Route::get('teste_wp', function () {
//     $wp_user_id = 5;
//     // $user = User::where('wp_user_id', $wp_user_id)->first();

//     $WPUser = WPUser::where('ID', $wp_user_id)->get();
//     if (!$WPUser) {
//         return;
//     }
//     $WPUserMeta = WPUserMeta::where('user_id', $wp_user_id)->get();

//     return response()->json($WPUserMeta);
// });
