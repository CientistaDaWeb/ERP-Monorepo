@extends('layouts.site')

@section('title', 'Área Restrita')

@section('content')
    <div class="page-title-2 center-holder">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h1>{{ Auth::user()->razao_social }}</h1>
                </div>
                <div class="col-4">
                    <a href="{{ route('sair') }}" class="btn btn-danger"> Sair</a>
                </div>
            </div>
        </div>
    </div>
    <div class="section-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if($certificados)
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th>Código</th>
                                <th>Data de Tratamento</th>
                                <th>Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($certificados AS $certificado)
                                <tr>
                                    <td>{{ $certificado->orcamento_id }}.{{ $certificado->os_sequencial }}</td>
                                    <td>{{ $certificado->inicio_tratamento? Carbon\Carbon::parse($certificado->inicio_tratamento)->format('d/m/Y') : '' }}
                                        - {{ $certificado->fim_tratamento? Carbon\Carbon::parse($certificado->fim_tratamento)->format('d/m/Y') : '' }}</td>
                                    <td><a href="/area-restrita/pesquisa/{{ base64_encode($certificado->id) }}"
                                           target="_blank">
                                            Certificado_{{ $certificado->orcamento_id .'_'. $certificado->id }}.pdf</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-dismissible white-color" style="background-color: #da4453;">
                            <strong>Erro!</strong> Sem certificados emitidos.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
