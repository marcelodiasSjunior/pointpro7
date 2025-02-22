<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAtestadoRequest;
use App\Models\Atestado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class AtestadosController extends Controller
{
    function anexarAtestado(UploadAtestadoRequest $request)
    {
        $user = $request->user();
        $funcionario = $user->funcionario;
        $funcionario_id = $funcionario->id;
        $company_id = $funcionario->company_id;
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $folder = 'atestados/' . $user->id;
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

        $startDate = Carbon::create($request->input('startYear'), $request->input('startMonth'), $request->input('startDay'));
        $endDate = Carbon::create($request->input('endYear'), $request->input('endMonth'), $request->input('endDay'));
        $endtime = $request->input(key: 'endTime');
        $startTime = $request->input(key: 'startTime');
        Atestado::create([
            'user_id' => $user->id,
            'funcionario_id' => $funcionario_id,
            'company_id' => $company_id,
            'path' => rtrim(config('app.host_asset_s3'), '/'), // Remover a barra final, se houver
            'file' => $folder . '/' . $fileName, // Adicionar o caminho completo aqui
            'media_type' => $mediaType,
            'dateUpload' => now(),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'startTime' => $startTime,
            'endTime' => $endtime
        ]);

        session()->flash('success', 'Atestado enviado com sucesso!');
        return redirect()->route('worker.home');
    }
}
