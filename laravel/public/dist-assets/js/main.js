var isLoadingCEP = false;
Dropzone.autoDiscover = false;

function getCities(state_id, city_name = '') {
    $.get('/api/cities/' + state_id, function (data, status) {
        if (status === 'success') {
            $('#cidades-select').html('');
            for (let i = 0; i < data.length; i++) {
                const item = data[i];
                $('#cidades-select').append(`<option value="${item.id}">${item.name}</option>`);
            }

            if (city_name.length > 0) {
                $('#cidades-select option').each(function () {
                    if ($(this).text() === city_name) {
                        $(this).attr("selected", "selected");
                    }
                });
            }

            if ($('#city_id_get').val() !== "") {
                $('#cidades-select option').each(function () {
                    if ($(this).val() === $('#city_id_get').val()) {
                        $(this).attr("selected", "selected");
                    }
                });
            }
        }
    })
}

function geocodeCep(cep = '') {
    if (!isLoadingCEP) {
        isLoadingCEP = true;
        $.get(`https://viacep.com.br/ws/${cep}/json/`, function (data, status) {
            if (data.erro || status !== 'success') {
                $('#input-cep').val("");
                alert("CEP Incorreto")
                isLoadingCEP = false;
                return;
            }
            isLoadingCEP = false;
            setState(data.uf, data.localidade);
            $("#input-endereco").val(data.logradouro);
            $("#input-bairro").val(data.bairro)
        });
    }


}

function setState(stateSearch, cityName) {
    $('#estados-select option').each(function () {
        if ($(this).attr('search') === stateSearch) {
            $(this).attr("selected", "selected");
            getCities($(this).val(), cityName)
        }
    });
}

function loadUsersForFuncao() {
    const funcao_id = $('.inputFuncao').find(":selected").val();

    $.get(`/funcionarios_by_funcao/${funcao_id}`, function (data, status) {
        $('.funcionarioHolder').html('');
        data.map((item) => {
            $('.funcionarioHolder').append(
                `<label class="checkbox checkbox-primary margin-check-3">
                    <input type="checkbox" value="${item.id}" name="funcionarios[]">
                    <span>${item.user.name}</span>
                    <span class="checkmark"></span>
                </label>`
            )
        })


    });

}


$('document').ready(function () {


    if ($('#edit-worker-user').length) {
        $('#edit-worker-user').dropzone({
            paramName: "picture",
            autoProcessQueue: true,
            maxFiles: 1,
            addRemoveLinks: true,
            dictResponseError: 'Server not Configured',
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.webp",
            init: function () {
                this.on("error", function (file) {
                });
                this.on("success", function (res) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    const { responseText } = res.xhr;
                    const { path, file } = JSON.parse(responseText);
                    $("#avatar").val(path + file);
                });
            }
        });
    }
    if ($('#edit-company-user').length) {
        const editPerfilCompanyUser = $('#edit-company-user').dropzone({
            paramName: "picture",
            autoProcessQueue: true,
            maxFiles: 1,
            addRemoveLinks: true,
            dictResponseError: 'Server not Configured',
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.webp",
            init: function () {
                this.on("error", function (file) {
                });
                this.on("success", function (res) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    const { responseText } = res.xhr;
                    const { path, file } = JSON.parse(responseText);
                    $("#company-user-avatar").val(path + file);
                });
            }
        });
    }


    if ($('.changePasswordInputType').length) {
        $('.changePasswordInputType').click(function () {
            const newInputType = $('#password').attr('type') === 'password' ? 'text' : 'password';
            $('#password').attr('type', newInputType);
        })
    }
    if ($("#input-cnpj").length) {
        $("#input-cnpj").mask("99.999.999/9999-99");
    }

    if ($(".input-cep").length) {
        $(".input-cep").mask('99999-999');
    }

    if ($("#input-cep").length) {
        $("#input-cep").mask('99999-999');
    }

    if ($("#input-cpf").length) {
        $("#input-cpf").mask('000.000.000-00');
    }
    if ($(".input-date").length) {
        $(".input-date").mask('00/00/0000');
    }

    // if ($('#estados-select option').length) {
    //     $.getJSON("https://api.ipify.org?format=json", function (data) {

    //         $.get('https://ip-api.com/json/' + data.ip, function (data, status) {
    //             if (status === 'success') {
    //                 setState(data.region, data.city);
    //             }
    //         });
    //     })
    // }

    if ($('#estados-select option').length) {
        $('#estados-select option').each(function () {
            if (this.selected) {
                getCities(this.value);
            }
        })
    }

    $('#estados-select').on('change', function () {
        getCities(this.value);
    });


    $('#input-cep').keyup(function (val) {
        const cep = val.target.value.replace("-", "");
        cep.length === 8 && geocodeCep(cep);
    })

    const inputPhone = '.input-phone';
    $(inputPhone).keydown(function () {
        try {
            $(inputPhone).unmask();
        } catch (e) { }

        if ($(inputPhone).val().length > 9) {
            $(inputPhone).mask('(00) 00000-0000');

        } else {
            $(inputPhone).mask('(00) 0000-0000');
        }

        // ajustando foco
        var elem = this;
        setTimeout(function () {
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 1000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });


    if ($('#create-company').length) {
        const myDropzone = $('#create-company').dropzone({
            paramName: "picture",
            autoProcessQueue: true,
            maxFiles: 1,
            addRemoveLinks: true,
            dictResponseError: 'Server not Configured',
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.webp",
            init: function () {

                this.on("error", function (file) {
                });
                this.on("success", function (res) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    const { responseText } = res.xhr;
                    const { path, file } = JSON.parse(responseText);
                    $("#input-logo").val(path + file);
                });
            }
        });
    }

    if ($('#document-onboarding').length) {
        const myDropzoneOnBoarding = $('#document-onboarding').dropzone({
            paramName: "pdf",
            autoProcessQueue: true,
            maxFiles: 1,
            addRemoveLinks: true,
            dictResponseError: 'Server not Configured',
            acceptedFiles: ".pdf,",
            init: function () {

                this.on("error", function (file) {
                });
                this.on("success", function (res) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    const { responseText } = res.xhr;
                    const { path, file } = JSON.parse(responseText);
                    $("#input-onboarding").val(path + file);
                });
            }
        });
    }
})
