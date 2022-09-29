@extends('layouts.site')

@section('title', 'Estação de Tratamento')

@section('content')
  @component('layouts.title')
    Estação de Tratamento
  @endcomponent
  <div class="section-block">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8">
          <p>A Estação de Tratamento de Efluentes da Acquasana foi implementada de acordo com as normas atuais vigentes.
            Nela são recebidos os efluentes de cabines de pinturas, vinícolas e assemelhados, de indústrias de pequeno e
            médio porte e efluentes domésticos, oriundos de fossas sépticas. A função da estação é tratar o efluente,
            emitindo laudos comprobatórios, solucionando assim os problemas de empresas que têm efluente estocado e/ou
            possuem um pequeno volume de efluentes, para os quais é inviável economicamente a instalação de uma planta
            individual.</p>
        </div>
        <div class="col-12 col-md-4 mt-15-xs">
          <img src="/img/content/estacao_tratamento.png" class="img-fluid"/>
        </div>
      </div>
    </div>
  </div>
  <div class="section-block-grey">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-heading left-holder">
            <h2 class="h4 bold">Efluentes Domésticos </h2>
            <h3 class="h5">Etapas do Tratamento</h3>
            <div class="section-heading-line"></div>
          </div>
        </div>
      </div>
      <div class="default-tabs">
        <div class='tabs tabs_animate mt-20'>
          <ul class="tab-menu left-holder">
            <li><a href="#tab-1">Armazenamento do Efluente</a></li>
            <li><a href="#tab-2">Tratamento Biológico</a></li>
            <li><a href="#tab-3">Descarte Final</a></li>
            <li><a href="#tab-4">Controle Final</a></li>
          </ul>
          <div id='tab-1' class="clearfix tab-body inner-30">
            <p>O efluente a ser tratado é transportado por um caminhão tanque até uma área de descarga, para que o mesmo
              seja bombeado à um tanque de equalização, que se encontra protegido pela bacia de contenção. Bombas de
              alto rendimento fazem com que o efluente siga ao tratamento de forma adequada.</p>
          </div>
          <div id='tab-2' class="clearfix tab-body inner-30">
            <p>O tratamento biológico consiste em dois reatores anaeróbios UASB e três reatores aeróbios com sistema de
              aerador submerso. combinando-se a agitação do esgoto com a injeção de ar, desenvolve-se no tanque de
              aeração uma massa líquida de microorganismos chamada lodo ativado. Através do sistema de lodo ativado com
              aeração prolongada, a matéria orgânica (poluente) é consumida pelos microrganismos, promovendo assim, a
              eliminação dos compostos orgânicos contidos no efluente. O lodo gerado passa por um processo de decantação
              e, a seguir, é enviado a um filtro-prensa para desidratação e o clarificado é enviado ao corpo hídrico
              receptor.</p>
          </div>
          <div id='tab-3' class="clearfix tab-body inner-30">
            <p>Todo lodo gerado no tratamento biológico é enviado para um tanque de armazenagem. Este é desaguado no
              filtro-prensa. O resíduo sólido formado é identificado, classificado e armazenado em recipientes
              apropriados e posteriormente enviado para descarte final em solo agrícola como fertilizante. O clarificado
              é lançado para o corpo hídrico receptor, atendendo aos padrões de emissão da Fepam.</p>
          </div>
          <div id='tab-4' class="clearfix tab-body inner-30">
            <p>No controle final, a qualidade do efluente tratado é medida e registrada continuamente de acordo com os
              dados de qualidade obtidos, o efluente tratado é direcionado para dois destinos: corpo hídrico receptor ou
              de volta ao processo de tratamento. Os parâmetros de todas as etapas intermediárias do tratamento são
              analisados em um laboratório credenciado pelo órgão fiscalizador, que presta assessoria à empresa. No
              laboratório são feitas as análises e exames fornecem dados para verificar a eficiência do tratamento. Ao
              final do tratamento, a Acquasana emite um laudo para o cliente, certificando o pelo tratamento realizado,
              no qual constam os padrões de emissão. Todo o processo de operação da E.T.E. é supervisionado por uma
              empresa terceirizada, isenta e altamente qualificada ambientalmente.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
