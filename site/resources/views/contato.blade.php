@extends('layouts.site')

@section('title', 'Contato')

@section('content')
    @component('layouts.title')
        Contato
    @endcomponent
    <div class="section-block pt-0 pb-0">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-md-6 col-sm-6 col-12">
                    <div class="contact-1-box padding-10-perc">
                        <div class="section-heading left-holder">
                            <small>Ficou com alguma dúvida?</small>
                            <h5 class="bold mt-0">Entre em contato!</h5>
                        </div>
                        <div class="mt-30">
                            <form class="bordered-form" method="POST">
                                @csrf
                                <div class="row">
                                    @if (Session::has('success'))
                                        <div class="col-12">
                                            <div class="alert alert-dismissible white-color"
                                                 style="background-color: #57bc90;">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                {{ Session::get('success') }}
                                            </div>
                                        </div>
                                    @endif
                                    @if (Session::has('error'))
                                        <div class="col-12">
                                            <div class="alert alert-dismissible white-color"
                                                 style="background-color: #da4453;">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                {{ Session::get('error') }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <input type="text" name="nome" placeholder="Nome *" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <input type="email" name="email" placeholder="E-mail *" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <input type="number" name="telefone" placeholder="Telefone *" required>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <input type="cidade" name="cidade" placeholder="Cidade *" required>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="mensagem" placeholder="Mensagem *"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <small>* Campos obrigatórios</small>
                                    </div>
                                    <div class="col-md-6 mt-10 mb-30 text-right">
                                        <button type="submit" class="primary-button button-sm semi-rounded">Enviar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="get-contact-1 rounded-border">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-map-marker-alt"></i> <span>R. Três de Outubro, 40</span>
                                </li>
                                <li class="list-group-item"><i class="fas fa-phone-square"></i> <span>Fone: (54) 3055-3686</span>
                                </li>
                                <li class="list-group-item"><i class="fa fa-envelope"></i> <span> acquasana@acquasana.com.br</span>
                                </li>
                            </ul>
                        </div>
                        <div class="bordered-form mt-40">
                            <div class="row">
                                <div class="col-12">
                                    <div class="small-heading center-holder mb-40">
                                        <span class="uppercase">Como chegar</span>
                                    </div>
                                </div>
                                <div class="col-8 align-self-center">
                                    <input type="text" id="saida" placeholder="De onde você quer chegar?" class="mb-0">
                                </div>
                                <div class="col-4 text-right align-self-center">
                                    <button class="primary-button button-sm full-width semi-rounded mr-0 mb-0"
                                            id="ComoChegar" type="button">Me mostre como chegar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <div id="mapa_canvas" class="full-height"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
