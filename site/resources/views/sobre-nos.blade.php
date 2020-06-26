@extends('layouts.site')

@section('title', 'Sobre Nós')

@section('content')
  @component('layouts.title')
    Sobre Nós
  @endcomponent
  <div class="section-block">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8">
          <p>Fundada no ano de 2008, com objetivo de oferecer soluções ambientais, sendo na coleta, tratamento e
            transporte, de efluentes domésticos e industriais, a Acquasana conta com estrutura para que estes
            efluentes sejam destinados de acordo com as leis ambientais vigentes. Possuímos estação de
            tratamento própria, juntamente com uma equipe de profissionais especializados, pois acreditamos em
            uma tendência mundial de preservação ambiental, na qual atitudes ecologicamente corretas não só
            agregam valor competitivo às empresas, mas também evidenciam a responsabilidade ambiental e a
            coletividade, para a preservação de nosso meio ambiente.</p>
          <div class="mt-15"></div>
          <p>A empresa atua na região nordeste do Rio Grande do Sul, com foco nas cidades de Bento Gonçalves,
            Garibaldi e Carlos Barbosa.</p>
        </div>
        <div class="col-12 col-md-4 mt-15-xs">
          <img src="/img/content/institucional.png" class="img-fluid"/>
        </div>
      </div>
      <div class="mt-70"></div>
    </div>
  </div>
@endsection
