<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPdfRequest;
use App\Http\Requests\UploadPictureRequest;
use App\Models\Upload;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    function picture(UploadPictureRequest $request)
    {
        $user = $request->user();

        $image = Image::make($request->file('picture'))->resize(1920, 1920, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 75);

        $folder = 'pictures/' . $user->id;

        $fileName = $folder . '/' . $user->id . '_' . time() . '_' . Str::random(20) . '.jpg';

        Storage::disk('s3')->put($fileName, $image);

        $upload = Upload::create([
            'user_id' => $user->id,
            'path' => config('app.host_asset_s3'),
            'file' => $fileName,
            'media_type' => 'picture'
        ]);

        return $upload;
    }

    function pdf(UploadPdfRequest $request)
    {
        $user = $request->user();

        $folder = 'pdf/' . $user->id;
        $fileName = $user->id . '_' . time() . '_' . Str::random(20) . '.pdf';

        $path = $request->file('pdf')->storePubliclyAs($folder, $fileName);

        $upload = Upload::create([
            'user_id' => $user->id,
            'path' => config('app.host_asset_s3'),
            'file' => $path,
            'media_type' => 'picture'
        ]);
        return $upload;
    }
}
