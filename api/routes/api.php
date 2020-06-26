<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
  $user = $request->user();
  return $user;
})->middleware(['auth:api', 'cors']);

Route::get('/orcamentos-servicos/download/{arq}', 'Api\OrcamentosServicosController@downloadPdf');
Route::get('/download/{nome}/{ext}/{arq}', 'Api\DownloadController@download');

Route::group(
  ['middleware' => ['client', 'cors']],
  function () {

    Route::resource(
      '/abastecimentos',
      'Api\AbastecimentosController'
    );

    Route::resource(
      '/aditivos',
      'Api\AditivosController'
    );

    Route::resource(
      '/administradores-arquivos',
      'Api\AdministradoresArquivosController'
    );

    Route::resource(
      '/administradores-condominios',
      'Api\AdministradoresCondominiosController'
    );

    Route::resource(
      '/administradores-condominios-t',
      'Api\AdministradoresCondominiosTelefonesController'
    );

    Route::resource(
      '/administradores-condominios-crm',
      'Api\AdministradoresCrmController'
    );

    Route::resource(
      '/arquitetos',
      'Api\ArquitetosController'
    );

    Route::resource(
      '/bancos',
      'Api\BancosController'
    );

    Route::resource(
      '/bens',
      'Api\BensController'
    );

    Route::resource(
      '/caminhoes',
      'Api\CaminhoesController'
    );

    Route::resource(
      '/certificados',
      'Api\CertificadosController'
    );

    Route::resource(
      '/cfops',
      'Api\CfopsController'
    );

    Route::resource(
      '/clientes',
      'Api\ClientesController'
    );

    Route::post('/clientes-arquivos/upload', 'Api\ClientesArquivosController@upload');
    Route::resource(
      '/clientes-arquivos',
      'Api\ClientesArquivosController'
    );

    Route::resource(
      '/clientes-categorias',
      'Api\ClientesCategoriasController'
    );

    Route::get('/clientes-crm/abertos', 'Api\ClientesCrmController@abertos');
    Route::resource(
      '/clientes-crm',
      'Api\ClientesCrmController'
    );

    Route::get('/clientes-enderecos/mapa', 'Api\ClientesEnderecosController@mapa');
    Route::resource(
      '/clientes-enderecos',
      'Api\ClientesEnderecosController'
    );

    Route::resource(
      '/clientes-telefones',
      'Api\ClientesTelefonesController'
    );

    Route::get('/contas-pagar/atrasadas', 'Api\ContasPagarController@atrasadas');
    Route::get('/contas-pagar/vencendo', 'Api\ContasPagarController@vencendo');
    Route::resource(
      '/contas-pagar',
      'Api\ContasPagarController'
    );

    Route::resource(
      '/contas-pagar-categorias',
      'Api\ContasPagarCategoriaController'
    );

    Route::resource(
      '/construtoras',
      'Api\ConstrutorasController'
    );

    Route::get('/contas-receber/atrasadas', 'Api\ContasReceberController@atrasadas');
    Route::get('/contas-receber/vencendo', 'Api\ContasReceberController@vencendo');
    Route::post('/contas-receber/salva-parcelas', 'Api\ContasReceberController@salvaParcelas');
    Route::resource(
      '/contas-receber',
      'Api\ContasReceberController'
    );

    Route::resource(
      '/contas-receber-ordens-servicos',
      'Api\ContasReceberOrdensServicosController'
    );

    Route::resource(
      '/contratos',
      'Api\ContratosController'
    );

    Route::resource(
      '/ctes-acqualife',
      'Api\CtesAcqualifeController'
    );

    Route::resource(
      '/ctes-acquaservicos',
      'Api\CtesAcquaservicosController'
    );

    Route::resource(
      '/ctes',
      'Api\CtesController'
    );

    Route::resource(
      '/empresas-arquvios',
      'Api\EmpresasArquivosController'
    );

    Route::resource(
      '/empresas-arquivos-categorias',
      'Api\EmpresasArquivosCategoriasController'
    );

    Route::resource(
      '/empresas',
      'Api\EmpresasController'
    );

    Route::resource(
      '/enderecos-categorias',
      'Api\EnderecosCategoriasController'
    );

    Route::resource(
      '/estados',
      'Api\EstadosController'
    );

    Route::resource(
      '/folgas',
      'Api\FolgasController'
    );

    Route::resource(
      '/formas-pagamento',
      'Api\FormasPagamentoController'
    );

    Route::resource(
      '/fornecedores-arquivos',
      'Api\FornecedoresArquviosController'
    );

    Route::resource(
      '/fornecedores-categorias',
      'Api\FornecedoresCategoriasController'
    );

    Route::resource(
      '/fornecedores',
      'Api\FornecedoresController'
    );

    Route::resource(
      '/fornecedores-crm',
      'Api\FornecedoresCrmController'
    );

    Route::resource(
      '/logs-acessos',
      'Api\LogsAcessosController'
    );

    Route::resource(
      '/logs-alteracoes',
      'Api\LogsAlteracoesController'
    );

    Route::resource(
      '/manutencoes',
      'Api\ManutencoesController'
    );

    Route::resource(
      '/manutencoes-pecas',
      'Api\ManutencoesPecasController'
    );

    Route::get('/modulos/menu/{usuario_id}', 'Api\ModulosController@menu');
    Route::resource(
      '/modulos',
      'Api\ModulosController'
    );

    Route::resource(
      '/modulos-categorias',
      'Api\ModulosCategoriasController'
    );

    Route::resource(
      '/mtr-dados',
      'Api\MtrDadosController'
    );

    Route::resource(
      '/mtrs',
      'Api\MtrsController'
    );

    Route::resource(
      '/municipios',
      'Api\MunicipiosController'
    );

    Route::resource(
      '/notas-fiscais',
      'Api\NotasFiscaisController'
    );

    Route::resource(
      '/notas-projetos',
      'Api\NotasProjetosController'
    );

    Route::get('/orcamentos/abertos', 'Api\OrcamentosController@abertos');
    Route::get('/orcamentos/divergencias', 'Api\OrcamentosController@divergencias');
    Route::resource(
      '/orcamentos',
      'Api\OrcamentosController'
    );

    Route::get('/orcamentos-servicos/visualizar/{id}', 'Api\OrcamentosServicosController@visualizar');
    Route::get('/orcamentos-servicos/pega-textos', 'Api\OrcamentosServicosController@pegaTextos');
    Route::post('/orcamentos-servicos/email', 'Api\OrcamentosServicosController@email');
    Route::resource(
      '/orcamentos-servicos',
      'Api\OrcamentosServicosController'
    );


    Route::get('/ordens-servico/atrasadas', 'Api\OrdensServicoController@atrasadas');
    Route::get('/ordens-servico/vencendo', 'Api\OrdensServicoController@vencendo');
    Route::resource(
      '/ordens-servico',
      'Api\OrdensServicoController'
    );

    Route::resource(
      '/ordem-servico-imagens',
      'Api\OrdemServicoImagensController'
    );

    Route::resource(
      '/ordens-servicos-servicos',
      'Api\OrdensServicosServicosController'
    );

    Route::resource(
      '/pecas',
      'Api\PecasController'
    );

    Route::resource(
      '/pesquisa-satisfacao',
      'Api\PesquisaSatisfacaoController'
    );

    Route::resource(
      '/projetos-alteracoes',
      'Api\ProjetosAlteracoesController'
    );

    Route::resource(
      '/projetos-arquitetonicos-arquivos',
      'Api\ProjetosArquitetonicosArquivosController'
    );

    Route::resource(
      '/projetos-arquitetonicos',
      'Api\ProjetosArquitetonicosController'
    );

    Route::resource(
      '/projetos-arquivos',
      'Api\ProjetosArquivosController'
    );

    Route::resource(
      '/projetos-atividades',
      'Api\ProjetosAtividadesController'
    );

    Route::resource(
      '/projetos-atividades-tempo',
      'Api\ProjetosAtividadesTempoController'
    );

    Route::resource(
      '/projetos-categorias',
      'Api\ProjetosCategoriasController'
    );

    Route::get('/projetos/ppci', 'Api\ProjetosController@ppci');
    Route::get('/projetos/hidro', 'Api\ProjetosController@hidro');
    Route::resource(
      '/projetos',
      'Api\ProjetosController'
    );

    Route::resource(
      '/projetos-crm',
      'Api\ProjetosCrmController'
    );

    Route::resource(
      '/projetos-envios',
      'Api\ProjetosEnviosController'
    );

    Route::resource(
      '/projetos-hidro',
      'Api\projetosHidroController'
    );

    Route::resource(
      '/projetos-ppci',
      'Api\ProjetosPpciController'
    );

    Route::get('/relatorios/fluxo-caixa', 'Api\RelatoriosController@fluxoCaixa');
    Route::get('/relatorios/fluxo-caixacsv', 'Api\RelatoriosController@fluxoCaixaCsv');
    Route::get('/relatorios/ordem-servico', 'Api\RelatoriosController@ordemServico');
    Route::get('/relatorios/orcamento', 'Api\RelatoriosController@orcamento');
    Route::get('/relatorios/atendimento', 'Api\RelatoriosController@atendimento');
    Route::get('/relatorios/contas-pagar', 'Api\RelatoriosController@contasPagar');
    Route::get('/relatorios/contas-receber', 'Api\RelatoriosController@contasReceber');
    Route::get('/relatorios/clientes-condominio', 'Api\RelatoriosController@clientesCondomonio');
    Route::get('/relatorios/nota-fiscal', 'Api\RelatoriosController@notaFiscal');
    Route::get('/relatorios/nota-projeto', 'Api\RelatoriosController@notaProjeto');
    Route::get('/relatorios/cliente', 'Api\RelatoriosController@cliente');
    Route::get('/relatorios/ordem-servico-csv', 'Api\RelatoriosController@ordemServicoCsv');
    Route::get('/relatorios/orcamento-csv', 'Api\RelatoriosController@orcamentosCsv');
    Route::get('/relatorios/atendimento-csv', 'Api\RelatoriosController@atendimentosCsv');
    Route::get('/relatorios/contas-pagar-csv', 'Api\RelatoriosController@contasPagarCsv');
    Route::get('/relatorios/contas-receber-csv', 'Api\RelatoriosController@contasReceberCsv');
    Route::get('/relatorios/clientes-condominio-csv', 'Api\RelatoriosController@clientesCondominioCsv');
    Route::get('/relatorios/nota-fiscal-csv', 'Api\RelatoriosController@notaFiscalCsv');
    Route::get('/relatorios/nota-projeto-csv', 'Api\RelatoriosController@notaProjetoCsv');
    Route::get('/relatorios/cliente-csv', 'Api\RelatoriosController@clienteCsv');

    Route::resource(
      '/remessas',
      'Api\RemessasController'
    );

    Route::resource(
      '/retornos',
      'Api\RetornosController'
    );

    Route::resource(
      '/servicos-categorias',
      'Api\ServicosCategoriasController'
    );

    Route::resource(
      '/servicos',
      'Api\ServicosController'
    );

    Route::resource(
      '/telefones-categorias',
      'Api\TelefonesCategoriasController'
    );

    Route::resource(
      '/templates',
      'Api\TemplatesController'
    );

    Route::resource(
      '/textos-categorias',
      'Api\TextosCategoriasController'
    );

    Route::resource(
      '/textos',
      'Api\TextosController'
    );

    Route::resource(
      '/transportadores',
      'Api\TransportadoresController'
    );

    Route::get('/usuarios-compromissos/compromissos', 'Api\UsuariosCompromissosController@compromissos');
    Route::resource(
      '/usuarios-compromissos',
      'Api\UsuariosCompromissosController'
    );

    Route::resource(
      '/usuarios',
      'Api\UsuariosController'
    );

    Route::resource(
      '/usuarios-modulos',
      'Api\UsuariosModulosController'
    );
  }
);
