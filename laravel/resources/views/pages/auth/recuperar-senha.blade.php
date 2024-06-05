@extends('templates.auth')
@section('content')

<div class="auth-layout-wrap" style="background-color:#ffffff;">
    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        @include('components.auth-messages')
                        <div class="auth-logo text-center mb-4">
                            <img src="{{ secure_asset('dist-assets/images/logo.svg') }}" alt="" />
                        </div>
                        <h1 class="mb-3 text-18">Esqueci minha senha</h1>
                        <form action="/enviar-codigo-recuperacao" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control form-control-rounded" id="email" type="email" name="email" />
                            </div>
                            <button class="btn btn-rounded btn-primary w-100 mt-2" type="submit">
                                Recuperar senha
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection