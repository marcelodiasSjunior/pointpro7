<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAtestadoRequest;
use App\Models\Atestado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Session;


class AtestadosController extends Controller
{
    function validaDatasValidas($startDate, $startTime, $endDate, $endTime): bool
    {
        $startDateTime = Carbon::parse($startDate->format('Y-m-d') . ' ' . $startTime);
        $endDateTime = Carbon::parse($endDate->format('Y-m-d') . ' ' . $endTime);
        return $startDateTime->lte($endDateTime);
    }
    function anexarAtestado(UploadAtestadoRequest $request)
    {
        $user = $request->user();

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
        if ($this->validaDatasValidas($startDate, $startTime, $endDate, $endtime)) {
            Atestado::create([
                'user_id' => $user->id,
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
        Session::flash('error', "Erro ao anexar atestado! Verifique a data e horário.");
        return redirect()->route('worker.home');
    }
}
