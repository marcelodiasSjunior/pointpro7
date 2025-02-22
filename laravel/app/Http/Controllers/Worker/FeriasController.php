<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitarFeriasRequest;
use App\Models\Ferias;
use App\Models\Notificacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class FeriasController extends Controller
{
    public function solicitarFerias(SolicitarFeriasRequest $request)
    {
        $user = $request->user();
        $funcionario = $user->funcionario;
        
        if (!$funcionario) {
            session()->flash('error', 'Funcionário não encontrado!');
            return redirect()->route('worker.home');
        }
        $file = $request->file('file');
        $folder = null;
        $fileName = null;
        $mediaType = null;
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $folder = 'ferias_docs/' . $funcionario->id;
            $fileName = $user->id . '_' . time() . '_' . Str::random(20) . '.' . $extension;
    
            if (in_array($extension, ['jpg', 'jpeg'])) {
                $image = Image::make($file)->resize(1920, 1920, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 75);
    
                Storage::disk('s3')->put($folder . '/' . $fileName, $image, 'public');
    
                $mediaType = 'picture';
            } else {
                Storage::disk('s3')->putFileAs($folder, $file, $fileName, 'public');
                $mediaType = 'pdf';
            }
        }

        $startDate = Carbon::create($request->input('startYear'), $request->input('startMonth'), $request->input('startDay'));
        $endDate = Carbon::create($request->input('endYear'), $request->input('endMonth'), $request->input('endDay'));
        
        Notificacao::create([
            'title' => 'Solicitação de Férias',
            'description' => "Solicitação de férias do funcionário {$user->name}!",
            'company_id' => $funcionario->company_id,
            'funcionario_id' => $funcionario->id,
            'read' => 0,
        ]);

        Ferias::create([
            'funcionario_id' => $funcionario->id,
            'company_id' => $funcionario->company_id,
            'path' => rtrim(config('app.host_asset_s3'), '/'), // Remover a barra final, se houver
            'file' => $folder . '/' . $fileName, // Adicionar o caminho completo aqui
            'media_type' => $mediaType,
            'dateUpload' => now(),
            'status' => 'pendente',
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
        
        session()->flash('success', 'Solicitação de Férias enviada para aprovação do gestor!');
        return redirect()->route('worker.home');
    }
}
