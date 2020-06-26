@extends('layouts.site')

@section('title', 'Área Restrita')

@section('content')
    @component('layouts.title')
        Área Restrita
    @endcomponent
    <div class="section-block">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-sm-12 col-12 offset-md-1">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="usuario"
                                       class="col-md-4 col-form-label text-md-right">Usuário</label>
                                <div class="col-md-6">
                                    <input id="usuario" type="usuario"
                                           class="form-control @error('usuario') is-invalid @enderror" name="usuario"
                                           value="{{ old('usuario') }}" required autocomplete="usuario" autofocus>

                                    @error('usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="senha"
                                       class="col-md-4 col-form-label text-md-right">Senha</label>
                                <div class="col-md-6">
                                    <input id="senha" type="password"
                                           class="form-control @error('senha') is-invalid @enderror"
                                           name="senha" required autocomplete="senha">

                                    @error('senha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 text-right">
                                    <button type="submit" class="primary-button button-sm semi-rounded">
                                        Entrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
