<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PRO7</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ secure_asset('dist-assets/css/themes/lite-purple.min.css?rand='.rand()) }}" rel="stylesheet" />
    <link href="{{ secure_asset('dist-assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ secure_asset('dist-assets/css/plugins/quill.bubble.min.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('dist-assets/css/plugins/quill.snow.min.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ secure_asset('dist-assets/css/main.css?rand='.rand()) }}" rel="stylesheet" />
    <style>
        #webcamWrapper {
            text-align: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        #webcam {
            width: 100%;
            max-width: 450px;
            margin-bottom: 40px;
        }

        #canvasWebcam {}
    </style>
</head>