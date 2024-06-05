<div id="webcamFacial" class="alert alert-dismissible fade show alert-card alert-danger" style="display:none" role="alert"><strong class="text-capitalize">Erro:</strong> :Foto invalida </div>
<div id="webcamWrapper">
    <div style="display:flex; flex-direction:row;">
        <button id="takePicture" class="btn btn-info btn-icon text-white" type="button" aria-haspopup="true" aria-expanded="false">
            <span class="ul-btn__icon"><i class="i-Camera"></i></span>
            <span class="ul-btn__text"> Tirar foto</span>
        </button>
    </div>


    <video id="webcam"></video>

    <button id="sendPicture" class="btn btn-success btn-icon text-white" style="display:none" type="button" aria-haspopup="true" aria-expanded="false">
        <span class="ul-btn__icon"><i class="i-Camera"></i></span>
        <span class="ul-btn__text"> Confirmar</span>
    </button>
    <canvas id="canvasWebcam"></canvas>
</div>
<input type="hidden" name="plainTextToken" value="{{ $plainTextToken }}" />
<input type="hidden" name="api_token_for_web" value="{{ $api_token_for_web }}" />
<input type="hidden" name="python_api_prefix" value="{{ config('app.python_api_prefix') }}" />
<div id="webcamWrapperOnboarding"></div>