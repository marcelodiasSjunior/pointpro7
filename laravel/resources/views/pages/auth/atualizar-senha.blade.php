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
                        <h1 class="mb-3 text-18">Recuperar senha</h1>
                        <form action="/salva-nova-senha" method="post" autocomplete="off">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}" />
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input class="form-control form-control-rounded" id="email" type="email" name="email" />
                            </div>
                            <div class="form-group senhaHideShow">
                                <label for="password">Senha</label>
                                <input class="form-control form-control-rounded" id="password" type="password" name="password" />
                                <i class="i-Eye changePasswordInputType"></i>
                            </div>
                            <div class="form-group senhaHideShow">
                                <label for="password_confirmation">Confirmar senha</label>
                                <input class="form-control form-control-rounded" id="password_confirmation" type="password" name="password_confirmation" />
                                <i class="i-Eye changePasswordInputType"></i>
                            </div>
                            <button class="btn btn-rounded btn-primary w-100 mt-2" type="submit">
                                Atualizar senha
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection