@extends('layouts.site')

@section('title', 'Legislação')

@section('content')
  @component('layouts.title')
    Legislação
  @endcomponent

  <div class="section-block">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-sm-12 col-12 offset-md-1">
          <div class="small-heading center-holder mb-30">
            <span class="uppercase">Legislação Federal</span>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
              <ul class="primary-list">
                <li>
                  <i class="fa fa-file-pdf"></i>
                  <a href="/legislacao/nbr_7229.pdf" title="Constituição Federal" target="_blank">NBR 7229</a>
                </li>
                <li>
                  <i class="fa fa-file-pdf"></i>
                  <a href="/legislacao/nbr_13969.pdf" title="Constituição Federal" target="_blank">NBR 13969</a>
                </li>
                <li>
                  <i class="fa fa-file-pdf"></i>
                  <a href="/legislacao/constituicao-federal.pdf" title="Constituição Federal" target="_blank">Constituição
                    Federal</a>
                </li>
                <li>
                  <i class="fa fa-file-pdf"></i>
                  <a href="/legislacao/constituicao-federal-lei-9605.pdf" title="Constituição Federal Lei 9605"
                     target="_blank">Constituição Federal Lei 9605</a>
                </li>
                <li>
                  <i class="fa fa-file-pdf"></i>
                  <a href="/legislacao/resolucao-20-conama.pdf" title="Resolução 20 CONAMA" target="_blank">Resolução 20
                    CONAMA</a>
                </li>
              </ul>
            </div>

            <div class="col-md-6 col-sm-6 col-12">
              <ul class="primary-list">
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/resolucao-303-conama.pdf"
                                                     title="Resolução 303 CONAMA" target="_blank">Resolução 303
                    CONAMA</a></li>
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/resolucao-357-conama.pdf"
                                                     title="Resolução 357 CONAMA" target="_blank">Resolução 357
                    CONAMA</a></li>
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/resolucao-375-conama.pdf"
                                                     title="Resolução 375 CONAMA" target="_blank">Resolução 375
                    CONAMA</a></li>
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/resolucao-420-antt.pdf"
                                                     title="Resolução 420 ANTT" target="_blank">Resolução 420 ANTT</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-block section-block-greyer">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-sm-12 col-12 offset-md-1">
          <div class="small-heading center-holder mb-30">
            <span class="uppercase">Legislação Estadual</span>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
              <ul class="primary-list">
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/decreto-lei-9921.pdf" title="Decreto de Lei 9921"
                                                     target="_blank">Decreto de Lei 9921</a></li>
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/lei-estadual-9921.pdf" title="Lei Estadual 9921"
                                                     target="_blank">Lei Estadual 9921</a></li>
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/portaria-estadual-0589.pdf"
                                                     title="Portaria Estadual 0589" target="_blank">Portaria Estadual
                    0589</a></li>
              </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-12">
              <ul class="primary-list">
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/resolucao-128-consema.pdf"
                                                     title="Resolução 128 CONSEMA" target="_blank">Resolução 128
                    CONSEMA</a></li>
                <li><i class="fa fa-file-pdf"></i><a href="/legislacao/resolucao-129-consema.pdf"
                                                     title="Resolução 129 CONSEMA" target="_blank">Resolução 129
                    CONSEMA</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-block">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-sm-12 col-12 offset-md-1">
          <div class="small-heading center-holder mb-30">
            <span class="uppercase">Legislação Municipal</span>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-12">
              <ul class="primary-list">
                <li>
                  <i class="fa fa-file-pdf"></i>
                  <a href="/legislacao/lei-municipal-4000.pdf" title="Lei Municipal 4000" target="_blank">Lei Municipal
                    4000</a>
                </li>
              </ul>
            </div>

            <div class="col-md-6 col-sm-6 col-12">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
