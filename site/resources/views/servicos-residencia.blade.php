@extends('layouts.site')

@section('title', 'Serviços')

@section('content')
    @component('layouts.title')
        Serviços para sua residência
    @endcomponent
    <div class="section-block">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <p>Realizamos Coleta, Transporte e Tratamento de efluentes provenientes dos Sistemas Fossa e Filtro,
                        e Caixa da Gordura, de residências. As fossas sépticas são as unidades de tratamento primário do
                        esgoto doméstico, localizadas junto às edificações, e nas quais são feitas a separação e a
                        transformação físico-química da matéria sólida contida no esgoto. Elas são necessárias, pois
                        diminuem o lançamento de dejetos humanos diretamente na natureza (solo, rios, lagos) ou na rede
                        de coleta pública, ajudando assim no combate a doenças, verminoses e endemias. Ela consiste de
                        um tanque enterrado (que pode ser construído no local ou comprado pré-fabricado), que recebe o
                        esgoto (dos vasos sanitários, bidês, chuveiros, ralos, tanques, etc...), retém a sua parte
                        sólida e inicia o processo biológico de purificação da parte líquida.</p>
                </div>
                <div class="col-12 col-md-4 mt-15-xs">
                    <img src="/img/content/residencia.png" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
    <div class="section-block section-block-greyer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading left-holder">
                        <h4 class="bold">Como funciona</h4>
                        <div class="section-heading-line"></div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <p>O esgoto in natura da residência é lançado na fossa para que, com um menor fluxo de água, a sua
                        parte
                        sólida possa se depositar, liberando a parte líquida. Uma vez que o esgoto entra na fossa
                        séptica,
                        bactérias anaeróbicas (isto é, que vivem na ausência do oxigênio) agem sobre a parte sólida,
                        decompondo-a. Esta decomposição, chamada anaeróbica, é importante, pois diminui a quantidade de
                        matéria orgânica do esgoto, uma vez que a fossa pode remover cerca de 40% da demanda biológica
                        de
                        oxigênio do esgoto. Assim, ele pode ser lançado na natureza causando menos prejuízos à
                        mesma.</p>
                </div>
                <div class="col-12 col-md-6">
                    <p>O efluente da fossa é lançado num filtro anaeróbico, onde ocorre o tratamento secundário do
                        mesmo,
                        pela decomposição dos poluentes por bactérias anaeróbicas, antes de ser lançado na rede pública.
                        No
                        entanto, à medida que a fossa séptica vai funcionando ocorre, no seu interior, um acúmulo de
                        material sólido (lodo) que contém microrganismos patogênicos e que, quando em grande quantidade,
                        podem obstruir totalmente a fossa e o filtro, reduzindo o tempo de retenção do efluente líquido
                        dentro da fossa, tornando menos eficaz o tratamento primário. Além disso, pode provocar
                        problemas de
                        entupimentos nos encanamentos e tubulações.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="section-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading left-holder">
                        <h4 class="bold">Manutenção da fossa séptica e filtro</h4>
                        <div class="section-heading-line"></div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <p>A limpeza da fossa séptica e do filtro deve ser efetuada a cada ano, de modo que não haja um
                        acúmulo
                        excessivo de lodo no seu interior, pois quando isso acontece, a fossa não consegue dar vazão ao
                        lançamento de esgoto que ocorre, não retendo mais sua parte sólida. Assim, o esgoto in natura é
                        lançado diretamente na rede de coleta sem passar pelo tratamento primário e as canalizações da
                        residência podem ter problemas de entupimento com o refluxo do material acumulado. Isso sem
                        mencionar os danos ao meio ambiente decorrentes do esgoto in natura. </p>
                </div>
                <div class="col-12 col-md-6">
                    <p>A limpeza da fossa séptica e do filtro deve ser feita de acordo com as disposições da NBR
                        7229/1993,
                        de modo a evitar danos à saúde e ao meio ambiente. A limpeza e remoção do lodo devem ser feitas
                        por
                        profissionais especializados que disponham de equipamentos adequados, para garantir o
                        não-contato
                        direto entre pessoas e lodo. Em nenhuma hipótese, sob pena de punições legais, o material
                        retirado
                        da fossa deve ser lançado em algum tipo de rio, lago ou canal de água pluvial. Ele deve ser
                        retirado
                        e conduzido até uma estação de tratamento. </p>
                </div>
            </div>
        </div>
    </div>
@endsection
