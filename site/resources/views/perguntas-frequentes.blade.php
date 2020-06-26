@extends('layouts.site')

@section('title', 'Perguntas Frequentes')

@section('content')
  @component('layouts.title')
    Perguntas Frequentes
  @endcomponent
  <div class="section-block">
    <div class="container">
      <div id="accordion3" role="tablist">
        <div class="card card-grey">
          <div class="card-header card-header-grey" role="tab" id="headinggr1">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapseggr1" aria-expanded="true"
                 aria-controls="collapseggr1">
                01. O que é esgoto?
              </a>
            </h5>
          </div>
          <div id="collapseggr1" class="collapse" role="tabpanel" aria-labelledby="headinggr1"
               data-parent="#accordion3">
            <div class="card-body card-body-grey">
              <p>Esgoto é o termo usado para as águas que, após a utilização humana, apresentam as suas características
                naturais alteradas. Conforme o uso predominante, comercial, industrial ou doméstico, essas águas
                apresentarão características diferentes e são genericamente designadas de águas residuais. A devolução
                do esgoto ao meio ambiente deveria, sempre, ser precedida de um tratamento, seguido do lançamento
                adequado no corpo receptor que pode ser um rio, um lago ou no mar através de um emissário submarino.</p>
              <p class="mt-15">O esgoto pode ser transportado por tubulações, diretamente aos rios, lagos, lagunas ou
                mares, ou levado
                às estações de tratamento, e depois de tratado, devolvido aos cursos d'água. Ele contém basicamente
                matéria orgânica e mineral, em solução e em suspensão, assim como alta quantidade de bactérias e outros
                organismos patogênicos e não patogênicos, assim como outros produtos que são indevidamente lançados na
                rede de esgoto.</p>
            </div>
          </div>
        </div>
        <div class="card card-grey">
          <div class="card-header card-header-grey" role="tab" id="headinggr2">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapsegr2" aria-expanded="false"
                 aria-controls="collapsegr2">
                02. Como funciona uma fossa séptica?
              </a>
            </h5>
          </div>
          <div id="collapsegr2" class="collapse" role="tabpanel" aria-labelledby="headinggr2" data-parent="#accordion3">
            <div class="card-body card-body-grey">
              <p>As fossas sépticas são as unidades de tratamento primário do esgoto doméstico, localizadas junto às
                edificações, e nas quais são feitas a separação e a transformação físico-química da matéria sólida
                contida no esgoto. Elas são necessárias, pois diminuem o lançamento de dejetos humanos diretamente na
                natureza (solo, rios, lagos) ou na rede de coleta pública, ajudando assim no combate a doenças,
                verminoses e endemias. Ela consiste de um tanque enterrado (que pode ser construído no local ou comprado
                pré-fabricado), que recebe o esgoto (dos vasos sanitários, bidês, chuveiros, ralos, tanques, etc...),
                retém a sua parte sólida e inicia o processo biológico de purificação da parte líquida. </p>
              <p class="mt-15">O esgoto in natura da residência é lançado na fossa para que, com um menor fluxo de água,
                a sua parte
                sólida possa se depositar, liberando a parte líquida. Uma vez que o esgoto entra na fossa séptica,
                bactérias anaeróbicas (isto é, que vivem na ausência do oxigênio) agem sobre a parte sólida,
                decompondo-a. Esta decomposição, chamada anaeróbica, é importante, pois diminui a quantidade de matéria
                orgânica do esgoto, uma vez que a fossa pode remover cerca de 40% da demanda biológica de oxigênio do
                esgoto. Assim, ele pode ser lançado na natureza causando menos prejuízos à mesma.</p>
            </div>
          </div>
        </div>
        <div class="card card-grey">
          <div class="card-header card-header-grey" role="tab" id="headinggr3">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapsegr3" aria-expanded="false"
                 aria-controls="collapsegr3">
                03. Por que terceirizar o tratamento do efluente industrial?
              </a>
            </h5>
          </div>
          <div id="collapsegr3" class="collapse" role="tabpanel" aria-labelledby="headinggr3" data-parent="#accordion3">
            <div class="card-body card-body-grey">
              <p>Com o objetivo de assegurar a conservação dos ecossistemas, o Brasil possui uma legislação que regula o
                descarte de efluentes sobre os corpos d'água, limitando a carga poluidora lançada pelas indústrias. Em
                virtude disso, o gerenciamento da questão ambiental tem se tornado uma preocupação constante das
                empresas nos dias atuais, que necessitam proceder o tratamento dos seus efluentes antes de lançá-los nos
                meios hídricos. Uma das alternativas de maior confiabilidade é a terceirização do tratamento do
                efluente, que fica sob inteira responsabilidade da empresa contratada, que procederá o tratamento em sua
                estação própria, dentro dos parâmetros tecnológicos e legais apropriados, garantindo a segurança
                operacional do processo.</p>
              <p class="mt-15">Assim, a indústria geradora do efluente, ao delegar o tratamento para uma empresa
                especializada na
                atividade, obtém uma solução imediata para seu passivo ambiental, repassando a responsabilidade sobre
                todo seu efluente gerado. A terceirização do tratamento também é mais viável em termos técnicos e
                econômicos, pois, independentemente de seu porte e ramo de atividade, ela poderá focar seu capital
                econômico e humano apenas na sua atividade fim.</p>
            </div>
          </div>
        </div>
        <div class="card card-grey">
          <div class="card-header card-header-grey" role="tab" id="headinggr4">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapsegr4" aria-expanded="false"
                 aria-controls="collapsegr4">
                04. Como utilizar o lodo do tratamento de esgotos como fertilizante?
              </a>
            </h5>
          </div>
          <div id="collapsegr4" class="collapse" role="tabpanel" aria-labelledby="headinggr4" data-parent="#accordion3">
            <div class="card-body card-body-grey">
              <p>Na busca de transformar um problema ambiental em benefício social, o resíduo da estação de tratamento
                de efluentes pode ser utilizado como fertilizante na agricultura. Esta prática é uma tendência mundial,
                utilizada em muitos países, sendo ainda de uso restrito no Brasil. Segundo informações da Embrapa
                (Cerrados-DF) o uso do lodo de esgoto tratado na agricultura pode ser uma opção econômica para
                produtores, pois ele é um insumo de baixo custo. Aplicado como fertilizante, o resíduo orgânico
                reciclado é rico em nutrientes como nitrogênio, fósforo e potássio, que são essenciais para o cultivo
                das lavouras. Pesquisadores da Embrapa já relatam experimentos, desde 2001, nos quais o lodo substituiu
                o fertilizante mineral em lavouras de grãos com bons índices de produtividade e redução de custos.</p>
              <p class="mt-15">Para ser utilizado na agricultura, o lodo deve estar em conformidade com a legislação do
                Conama, o que
                dá garantia ao produtor de um fertilizante barato e seguro. Os produtores interessados em utilizar o
                lodo na sua propriedade devem, por lei, apresentar um projeto agronômico assinado por engenheiro
                agrônomo à Fepam, que fornecerá orientações sobre o manejo do lodo como fertilizante, de modo a garantir
                a saúde do ser humano e evitar danos ao meio ambiente. Para maiores informações, consulte o site da
                Embrapa Meio Ambiente: www.cnpma.embrapa.br.</p>
            </div>
          </div>
        </div>
        <div class="card card-grey">
          <div class="card-header card-header-grey" role="tab" id="headinggr5">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapsegr5" aria-expanded="false"
                 aria-controls="collapsegr5">
                05. Quais cidades a Acquasana atende?
              </a>
            </h5>
          </div>
          <div id="collapsegr5" class="collapse" role="tabpanel" aria-labelledby="headinggr5" data-parent="#accordion3">
            <div class="card-body card-body-grey">
              <p>A empresa atua na região nordeste do Rio Grande do Sul, com foco nas cidades de Bento Gonçalves,
                Garibaldi e Carlos Barbosa.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
