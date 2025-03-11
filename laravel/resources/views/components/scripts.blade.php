<script src="{{ secure_asset('dist-assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/script.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/sidebar.large.script.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/plugins/echarts.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/echart.options.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/plugins/quill.min.js?rand=') . rand() }}"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/quill.script.min.js?rand=') . rand() }}"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/customizer.script.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/scripts/landing.script.js?rand=') . rand() }}"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="{{ secure_asset('dist-assets/js/plugins/jquery.mask.min.js') }}"></script>
<script src="{{ secure_asset('dist-assets/js/main.js?rand=') . rand() }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* -----------------------------
  Pre Loader
  ----------------------------- */
    $(window).on("load", function () {
        "use strict";
        $(".loadscreen").delay(200).fadeOut();
        // $('#preloader').delay(800).fadeOut('slow');
    });
</script>

<!-- DIVIDE HERE -->
<script>
    function showErrorWebcam() {
        $('#webcamFacial').show();
    }

    function saveFacial(form) {


    }

    function getLocation(callback) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(callback, function() {
                alert("Não foi possível obter sua localização.");
            });
        } else {
            alert("Geolocalização não é suportada pelo seu navegador.");
        }
    }
    
    function recognizeUser() {
        $(".loadscreen").show();
        const plainTextToken = $('input[name=plainTextToken]').val();

        var canvas = document.querySelector("#canvasWebcam");

        canvas.toBlob(function (blob) {
            var form = new FormData();
            form.append('file', blob, 'webcam.jpg');
            form.append('api_token_for_web', $('input[name=api_token_for_web]').val());
            form.append('direction', $('input[name=direction]').val());

            // Get the current address using geolocation
            getLocation(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Use OpenStreetMap Nominatim API to convert coordinates to address
                const geocodeUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;

                fetch(geocodeUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.address) {
                            const currentAddress = `${data.address.road},
                                ${data.address.house_number}, 
                                ${data.address.suburb}, 
                                ${data.address.city}, 
                                ${data.address.postcode}`;
                            console.log('Current address:', currentAddress);
                            form.append('current_address', currentAddress); // Append the current address

                            const url_prefix = $('input[name=python_api_prefix]').val() + 'recognizer';

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', url_prefix, true);
                            xhr.onload = function (e) {
                                try {
                                    const response = JSON.parse(e?.target?.response);
                                    window.location.reload();
                                    $(".loadscreen").hide();
                                } catch (e) {
                                    $(".loadscreen").hide();
                                    showErrorWebcam();
                                    throw e;
                                }
                            };
                            xhr.onerror = function (e) {
                                $(".loadscreen").hide();
                                showErrorWebcam();
                                throw e;
                            }

                            xhr.send(form);
                        } else {
                            $(".loadscreen").hide();
                            showErrorWebcam();
                            console.error('Geocoding failed');
                        }
                    })
                    .catch(error => {
                        $(".loadscreen").hide();
                        showErrorWebcam();
                        console.error('Error:', error);
                    });
            });
            form.append('latitude', lat);
            form.append('longitude', lng);
        }, 'image/jpeg');
    }

    function recognizeUserDefault() {
        $(".loadscreen").show();
        const plainTextToken = $('input[name=plainTextToken]').val();
        var form = new FormData();
        form.append('api_token_for_web', $('input[name=api_token_for_web]').val());
        form.append('direction', $('input[name=direction]').val());

        const url_prefix = $('input[name=python_api_prefix]').val() + 'recognizerDefault';
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url_prefix, true);
        xhr.onload = function (e) {
            try {
                const response = JSON.parse(e?.target?.response);
                window.location.reload();
                $(".loadscreen").hide();
            } catch (e) {
                console.log("Linha 97 ----> " + e);
                $(".loadscreen").hide();
                showErrorBatida();
                throw e;
            }
        };
        xhr.onerror = function (e) {
            console.log("Linha 104 -----> " + e.message);
            $(".loadscreen").hide();
            showErrorBatida();
            throw e;
        }

        xhr.send(form);
    }

    $('document').ready(() => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                console.log("Permissão concedida. Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude);
            }, function (error) {
                console.error("Erro ao solicitar localização:", error.message);
            });
        }
        if ($('#folhaPontoDefault').length) {
            if ($('#takePicture').length) {
                document.querySelector('#takePicture').addEventListener('click', function (e) {
                    recognizeUserDefault();
                })
            }
        } else {
            if ($('#sendPicturePonto').length) {
                document.querySelector('#sendPicturePonto').addEventListener('click', function (e) {
                    recognizeUser();
                })
                const webcamElementId = "#webcam";
                navigator.mediaDevices.getUserMedia({
                    video: true
                })
                    .then(function (mediaStream) {
                        const video = document.querySelector(webcamElementId);
                        video.srcObject = mediaStream;
                        video.play();

                        document.querySelector('#takePicture').addEventListener('click', function (e) {
                            var canvas = document.querySelector("#canvasWebcam");
                            if (canvas) {
                                canvas.height = video.videoHeight;
                                canvas.width = video.videoWidth;
                                var context = canvas.getContext('2d');
                                context.drawImage(video, 0, 0)

                                $('#sendPicturePonto').show();
                            }

                        })
                    })
                    .catch(function (err) {
                        throw err
                        console.log('Não há permissões para acessar a webcam')
                    })
            }
        }

    })
</script>



<script>
    $('document').ready(() => {
        if ($('#webcamWrapperOnboarding').length) {
            if ($('#sendPicture').length) {
                document.querySelector('#sendPicture').addEventListener('click', function (e) {
                    registerFacial();
                })
                const webcamElementId = "#webcam";
                navigator.mediaDevices.getUserMedia({
                    video: true
                })
                    .then(function (mediaStream) {
                        const video = document.querySelector(webcamElementId);
                        video.srcObject = mediaStream;
                        video.play();

                        document.querySelector('#takePicture').addEventListener('click', function (e) {
                            var canvas = document.querySelector("#canvasWebcam");
                            canvas.height = video.videoHeight;
                            canvas.width = video.videoWidth;
                            var context = canvas.getContext('2d');
                            context.drawImage(video, 0, 0)

                            $('#sendPicture').show();
                        })
                    })
                    .catch(function (err) {
                        throw err
                        console.log('Não há permissões para acessar a webcam')
                    })
            }
        }
    })

    function showErrorWebcam() {
        $('#webcamFacial').show();
    }

    function showErrorBatida() {
        alert('Erro ao enviar dados, por favor tente novamente.')
    }

    function saveFacial(form) {

        const url_prefix = $('input[name=python_api_prefix]').val() + 'register';

        form.append('api_token_for_web', $('input[name=api_token_for_web]').val());


        var xhr = new XMLHttpRequest();
        xhr.open('POST', url_prefix, true);
        xhr.onload = function (e) {
            try {
                const response = JSON.parse(e?.target?.response);
                window.location.reload();
                $(".loadscreen").hide();
            } catch (e) {
                $(".loadscreen").hide();
                showErrorWebcam();
                throw e;
            }
        };
        xhr.onerror = function (e) {
            $(".loadscreen").hide();
            showErrorWebcam();
            throw e;
        }

        xhr.send(form);
    }

    function registerFacial() {
        $(".loadscreen").show();
        const plainTextToken = $('input[name=plainTextToken]').val();

        var canvas = document.querySelector("#canvasWebcam");

        canvas.toBlob(function (blob) {
            var form = new FormData();
            form.append('picture', blob, 'webcam.jpg');
            // Upload
            var xhrUpload = new XMLHttpRequest();
            xhrUpload.open('POST', '/api/upload-picture', true);
            xhrUpload.setRequestHeader('Authorization', 'Bearer ' + plainTextToken);
            xhrUpload.onload = function (e) {
                const response = JSON.parse(e?.target?.response);
                form.append('upload_id', response.id)
                saveFacial(form);
            }
            xhrUpload.onerror = function (e) {
                $(".loadscreen").hide();
                throw e;
            }
            xhrUpload.send(form);
        }, 'image/jpeg');
    }
</script>