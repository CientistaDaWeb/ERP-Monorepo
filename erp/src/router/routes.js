/*
 * Using this package https://github.com/raniesantos/vue-routisan
 * to beautify routes. For example
 * {
 *   path: '/',
 *   component: () => import('layouts/default'),
 *   children: [
 *     { path: '', component: () => import('pages/index') }
 *   ]
 * }
 *
 */
import {
  web,
  auth,
  guest
} from 'src/router/middlewares'
import Route from 'vue-routisan'
// Define path where your views are stored
Route.setViewResolver(component => require('src/pages/' + component).default)

Route.group({
  beforeEnter: [web, auth]
}, () => {
  Route.redirect('/', '/dashboard')

  Route.view('/dashboard', 'layouts/default')
    .children(() => {
      Route.view('', 'dashboard/index').name('dashboard')
    })

  Route.view('/abastecimentos', 'layouts/default')
    .children(() => {
      Route.view('', 'abastecimentos/index').name('abastecimentos.index')
      Route.view('novo', 'abastecimentos/novo').name('abastecimentos.novo')
      Route.view(':id/editar/:tab?', 'abastecimentos/editar').name('abastecimentos.editar')
    })

  Route.view('/aditivos', 'layouts/default')
    .children(() => {
      Route.view('', 'aditivos/index').name('aditivos.index')
      Route.view('novo', 'aditivos/novo').name('aditivos.novo')
      Route.view(':id/editar/:tab?', 'aditivos/editar').name('aditivos.editar')
    })

  Route.view('/administradores-condominio', 'layouts/default')
    .children(() => {
      Route.view('', 'administradores-condominio/index').name('administradores-condominio.index')
      Route.view('novo', 'administradores-condominio/novo').name('administradores-condominio.novo')
      Route.view(':id/editar/:tab?', 'administradores-condominio/editar').name('administradores-condominio.editar')
    })

  Route.view('/agenda-ordens-servico', 'layouts/default')
    .children(() => {
      Route.view('', 'agenda-ordens-servico/ordensServicos').name('agenda-ordens-servico.index')
      Route.view('novo', 'desenvolvimento/novo').name('agenda-ordens-servico.novo')
      Route.view(':id/editar/:tab?', 'agenda-ordens-servico/editar').name('agenda-ordens-servico.editar')
    })

  Route.view('/agenda', 'layouts/default')
    .children(() => {
      Route.view('', 'agenda/compromissos').name('agenda.index')
      Route.view('novo', 'agenda/novo').name('agenda.novo')
      Route.view(':id/editar/:tab?', 'desenvolvimento/editar').name('agenda.editar')
      Route.view('viel', 'agenda/viel').name('agenda.viel')
      Route.view('relatorio', 'agenda/relatorio').name('agenda.relatorio')
    })

  Route.view('/arquitetos', 'layouts/default')
    .children(() => {
      Route.view('', 'arquitetos/index').name('arquitetos.index')
      Route.view('novo', 'arquitetos/novo').name('arquitetos.novo')
      Route.view(':id/editar/:tab?', 'arquitetos/editar').name('arquitetos.editar')
    })

  Route.view('/atendimentos', 'layouts/default')
    .children(() => {
      Route.view('relatorio', 'atendimentos/relatorio').name('atendimentos.relatorio')
    })

  Route.view('/bancos', 'layouts/default')
    .children(() => {
      Route.view('', 'bancos/index').name('bancos.index')
      Route.view('novo', 'bancos/novo').name('bancos.novo')
      Route.view(':id/editar/:tab?', 'bancos/editar').name('bancos.editar')
    })

  Route.view('/bens', 'layouts/default')
    .children(() => {
      Route.view('', 'bens/index').name('bens.index')
      Route.view('novo', 'bens/novo').name('bens.novo')
      Route.view(':id/editar/:tab?', 'bens/editar').name('bens.editar')
    })

  Route.view('/caminhoes', 'layouts/default')
    .children(() => {
      Route.view('', 'caminhoes/index').name('caminhoes.index')
      Route.view('novo', 'caminhoes/novo').name('caminhoes.novo')
      Route.view(':id/editar/:tab?', 'caminhoes/editar').name('caminhoes.editar')
    })

  Route.view('/certificados', 'layouts/default')
    .children(() => {
      Route.view('', 'certificados/index').name('certificados.index')
      Route.view(':id/editar/:tab?', 'certificados/editar').name('certificados.editar')
    })

  Route.view('/cfops', 'layouts/default')
    .children(() => {
      Route.view('', 'cfops/index').name('cfops.index')
      Route.view('novo', 'cfops/novo').name('cfops.novo')
      Route.view(':id/editar/:tab?', 'cfops/editar').name('cfops.editar')
    })

  Route.view('/clientes', 'layouts/default')
    .children(() => {
      Route.view('', 'clientes/index').name('clientes.index')
      Route.view('novo', 'clientes/novo').name('clientes.novo')
      Route.view(':id/editar/:tab?', 'clientes/editar').name('clientes.editar')
      Route.view('relatorio', 'clientes/relatorio').name('clientes.relatorio')
      Route.view('relatorio-atendidos', 'clientes/relatorio-atendidos').name('clientes.relatorio-atendidos')
      Route.view('relatorio-cadastrados', 'clientes/relatorio-cadastrados').name('clientes.relatorio-cadastrados')
      Route.view('relatorio-condomínios', 'clientes/relatorio-condominios').name('clientes.relatorio-condominios')
    })

  Route.view('/clientes-mapa', 'layouts/default')
    .children(() => {
      Route.view('', 'clientes-mapa/index').name('clientes-mapa.index')
    })

  Route.view('/clientes-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'clientes-categorias/index').name('clientes-categorias.index')
      Route.view('novo', 'clientes-categorias/novo').name('clientes-categorias.novo')
      Route.view(':id/editar/:tab?', 'clientes-categorias/editar').name('clientes-categorias.editar')
    })

  Route.view('/clientes-crm', 'layouts/default')
    .children(() => {
      Route.view('novo/:cliente_id', 'clientes-crm/novo').name('clientes-crm.novo')
      Route.view(':id/editar/:cliente_id', 'clientes-crm/editar').name('clientes-crm.editar')
    })

  Route.view('/clientes-enderecos', 'layouts/default')
    .children(() => {
      Route.view('novo/:cliente_id', 'clientes-enderecos/novo').name('clientes-enderecos.novo')
      Route.view(':id/editar/:cliente_id', 'clientes-enderecos/editar').name('clientes-enderecos.editar')
    })

  Route.view('/clientes-telefones', 'layouts/default')
    .children(() => {
      Route.view('novo/:cliente_id', 'clientes-telefones/novo').name('clientes-telefones.novo')
      Route.view(':id/editar/:cliente_id', 'clientes-telefones/editar').name('clientes-telefones.editar')
    })

  Route.view('/construtoras', 'layouts/default')
    .children(() => {
      Route.view('', 'construtoras/index').name('construtoras.index')
      Route.view('novo', 'construtoras/novo').name('construtoras.novo')
      Route.view(':id/editar/:tab?', 'construtoras/editar').name('construtoras.editar')
    })

  Route.view('/contas-pagar', 'layouts/default')
    .children(() => {
      Route.view('', 'contas-pagar/index').name('contas-pagar.index')
      Route.view('novo', 'contas-pagar/novo').name('contas-pagar.novo')
      Route.view(':id/editar/:tab?', 'contas-pagar/editar').name('contas-pagar.editar')
      Route.view(':id/baixar', 'desenvolvimento/index').name('contas-pagar.baixar')
      Route.view('relatorio', 'contas-pagar/relatorio').name('contas-pagar.relatorio')
    })

  Route.view('/contas-pagar-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'contas-pagar-categorias/index').name('contas-pagar-categorias.index')
      Route.view('novo', 'contas-pagar-categorias/novo').name('contas-pagar-categorias.novo')
      Route.view(':id/editar/:tab?', 'contas-pagar-categorias/editar').name('contas-pagar-categorias.editar')
    })

  Route.view('/contas-receber', 'layouts/default')
    .children(() => {
      Route.view('', 'contas-receber/index').name('contas-receber.index')
      Route.view('novo', 'contas-receber/novo').name('contas-receber.novo')
      Route.view(':id/editar/:tab?', 'contas-receber/editar').name('contas-receber.editar')
      Route.view(':id/baixar', 'desenvolvimento/index').name('contas-receber.baixar')
      Route.view('relatorio', 'contas-receber/relatorio').name('contas-receber.relatorio')
    })

  Route.view('/contratos', 'layouts/default')
    .children(() => {
      Route.view('', 'contratos/index').name('contratos.index')
      Route.view('novo', 'contratos/novo').name('contratos.novo')
      Route.view(':id/editar/:tab?', 'contratos/editar').name('contratos.editar')
      Route.view('relatorio', 'contratos/relatorio').name('contratos.relatorio')
    })

  Route.view('/ctes', 'layouts/default')
    .children(() => {
      Route.view('', 'desenvolvimento/index').name('ctes.index')
      Route.view('novo', 'ctes/novo').name('ctes.novo')
      Route.view(':id/editar/:tab?', 'ctes/editar').name('ctes.editar')
      Route.view('relatorio', 'ctes/relatorio').name('ctes.relatorio')
      Route.view('importar', 'ctes/importar').name('ctes.importar')
    })

  Route.view('/ctes-acqualife', 'layouts/default')
    .children(() => {
      Route.view('', 'ctes-acqualife/index').name('ctes-acqualife.index')
      Route.view('novo', 'ctes-acqualife/novo').name('ctes-acqualife.novo')
      Route.view(':id/editar/:tab?', 'ctes-acqualife/editar').name('ctes-acqualife.editar')
      Route.view('relatorio', 'ctes-acqualife/relatorio').name('ctes-acqualife.relatorio')
      Route.view('importar', 'ctes-acqualife/importar').name('ctes-acqualife.importar')
    })

  Route.view('/ctes-acquaservicos', 'layouts/default')
    .children(() => {
      Route.view('', 'ctes-acquaservicos/index').name('ctes-acquaservicos.index')
      Route.view('novo', 'ctes-acquaservicos/novo').name('ctes-acquaservicos.novo')
      Route.view(':id/editar/:tab?', 'ctes-acquaservicos/editar').name('ctes-acquaservicos.editar')
      Route.view('relatorio', 'ctes-acquaservicos/relatorio').name('ctes-acquaservicos.relatorio')
      Route.view('importar', 'ctes-acquaservicos/importar').name('ctes-acquaservicos.importar')
    })

  Route.view('/dres', 'layouts/default')
    .children(() => {
      Route.view('', 'dres/relatorio').name('dres.index')
    })

  Route.view('/empresas-arquivos-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'empresas-arquivos-categorias/index').name('empresas-arquivos-categorias.index')
      Route.view('novo', 'empresas-arquivos-categorias/novo').name('empresas-arquivos-categorias.novo')
      Route.view(':id/editar/:tab?', 'empresas-arquivos-categorias/editar').name('empresas-arquivos-categorias.editar')
    })

  Route.view('/empresas', 'layouts/default')
    .children(() => {
      Route.view('', 'empresas/index').name('empresas.index')
      Route.view('novo', 'empresas/novo').name('empresas.novo')
      Route.view(':id/editar/:tab?', 'empresas/editar').name('empresas.editar')
    })

  Route.view('/enderecos-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'enderecos-categorias/index').name('enderecos-categorias.index')
      Route.view('novo', 'enderecos-categorias/novo').name('enderecos-categorias.novo')
      Route.view(':id/editar/:tab?', 'enderecos-categorias/editar').name('enderecos-categorias.editar')
    })

  Route.view('/estados', 'layouts/default')
    .children(() => {
      Route.view('', 'estados/index').name('estados.index')
      Route.view('novo', 'estados/novo').name('estados.novo')
      Route.view(':id/editar/:tab?', 'estados/editar').name('estados.editar')
    })

  Route.view('/fluxo-de-caixa', 'layouts/default')
    .children(() => {
      Route.view('', 'fluxo-de-caixa/relatorio').name('fluxo-de-caixa.index')
    })

  Route.view('/folgas', 'layouts/default')
    .children(() => {
      Route.view('', 'folgas/index').name('folgas.index')
      Route.view('novo', 'folgas/novo').name('folgas.novo')
      Route.view(':id/editar/:tab?', 'desenvolvimento/editar').name('folgas.editar')
    })

  Route.view('/formas-pagamento', 'layouts/default')
    .children(() => {
      Route.view('', 'formas-pagamento/index').name('formas-pagamento.index')
      Route.view('novo', 'formas-pagamento/novo').name('formas-pagamento.novo')
      Route.view(':id/editar/:tab?', 'formas-pagamento/editar').name('formas-pagamento.editar')
    })

  Route.view('/fornecedores-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'fornecedores-categorias/index').name('fornecedores-categorias.index')
      Route.view('novo', 'fornecedores-categorias/novo').name('fornecedores-categorias.novo')
      Route.view(':id/editar/:tab?', 'fornecedores-categorias/editar').name('fornecedores-categorias.editar')
    })

  Route.view('/fornecedores', 'layouts/default')
    .children(() => {
      Route.view('', 'fornecedores/index').name('fornecedores.index')
      Route.view('novo', 'fornecedores/novo').name('fornecedores.novo')
      Route.view(':id/editar/:tab?', 'fornecedores/editar').name('fornecedores.editar')
    })

  Route.view('/livro-ponto', 'layouts/default')
    .children(() => {
      Route.view('', 'desenvolvimento/index').name('livro-ponto.index')
      Route.view('novo', 'desenvolvimento/novo').name('livro-ponto.novo')
      Route.view(':id/editar/:tab?', 'livro-ponto/editar').name('livro-ponto.editar')
      Route.view('relatorio', 'livro-ponto/relatorio').name('livro-ponto.relatorio')
    })

  Route.view('/logs-acessos', 'layouts/default')
    .children(() => {
      Route.view('', 'logs-acessos/index').name('logs-acessos.index')
      Route.view('novo', 'desenvolvimento/novo').name('logs-acessos.novo')
      Route.view(':id/editar/:tab?', 'desenvolvimento/editar').name('logs-acessos.editar')
    })

  Route.view('/logs-alteracoes', 'layouts/default')
    .children(() => {
      Route.view('', 'logs-alteracoes/index').name('logs-alteracoes.index')
      Route.view('novo', 'desenvolvimento/novo').name('logs-alteracoes.novo')
      Route.view(':id/editar/:tab?', 'desenvolvimento/editar').name('logs-alteracoes.editar')
    })

  Route.view('/manutencoes', 'layouts/default')
    .children(() => {
      Route.view('', 'manutencoes/index').name('manutencoes.index')
      Route.view('novo', 'manutencoes/novo').name('manutencoes.novo')
      Route.view(':id/editar/:tab?', 'manutencoes/editar').name('manutencoes.editar')
      Route.view('relatorio', 'manutencoes/relatorio').name('manutencoes.relatorio')
    })

  Route.view('/modulos', 'layouts/default')
    .children(() => {
      Route.view('', 'modulos/index').name('modulos.index')
      Route.view('novo', 'modulos/novo').name('modulos.novo')
      Route.view(':id/editar/:tab?', 'modulos/editar').name('modulos.editar')
    })

  Route.view('/modulos-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'modulos-categorias/index').name('modulos-categorias.index')
      Route.view('novo', 'modulos-categorias/novo').name('modulos-categorias.novo')
      Route.view(':id/editar/:tab?', 'modulos-categorias/editar').name('modulos-categorias.editar')
    })

  Route.view('/mtrs', 'layouts/default')
    .children(() => {
      Route.view('', 'mtrs/index').name('mtrs.index')
      Route.view('novo', 'mtrs/novo').name('mtrs.novo')
      Route.view(':id/editar/:tab?', 'mtrs/editar').name('mtrs.editar')
    })

  Route.view('/municipios', 'layouts/default')
    .children(() => {
      Route.view('', 'municipios/index').name('municipios.index')
      Route.view('novo', 'municipios/novo').name('municipios.novo')
      Route.view(':id/editar/:tab?', 'municipios/editar').name('municipios.editar')
    })

  Route.view('/notas-fiscais', 'layouts/default')
    .children(() => {
      Route.view('', 'notas-fiscais/index').name('notas-fiscais.index')
      Route.view('novo', 'notas-fiscais/novo').name('notas-fiscais.novo')
      Route.view(':id/editar/:tab?', 'notas-fiscais/editar').name('notas-fiscais.editar')
      Route.view('relatorio', 'notas-fiscais/relatorio').name('notas-fiscais.relatorio')
    })

  Route.view('/notas-projetos', 'layouts/default')
    .children(() => {
      Route.view('', 'notas-projetos/index').name('notas-projetos.index')
      Route.view('novo', 'notas-projetos/novo').name('notas-projetos.novo')
      Route.view(':id/editar/:tab?', 'notas-projetos/editar').name('notas-projetos.editar')
      Route.view('relatorio', 'notas-projetos/relatorio').name('notas-projetos.relatorio')
    })

  Route.view('/orcamentos', 'layouts/default')
    .children(() => {
      Route.view('', 'orcamentos/index').name('orcamentos.index')
      Route.view('novo', 'orcamentos/novo').name('orcamentos.novo')
      Route.view(':id/editar/:tab?', 'orcamentos/editar').name('orcamentos.editar')
      Route.view('relatorio', 'orcamentos/relatorio').name('orcamentos.relatorio')
    })

  Route.view('/ordens-servico', 'layouts/default')
    .children(() => {
      Route.view('', 'ordens-servico/index').name('ordens-servico.index')
      Route.view('novo/:orcamento_id', 'ordens-servico/novo').name('ordens-servico.novo')
      Route.view(':id/editar/:tab?', 'ordens-servico/editar').name('ordens-servico.editar')
      Route.view('relatorio', 'ordens-servico/relatorio').name('ordens-servico.relatorio')
    })

  Route.view('/pecas', 'layouts/default')
    .children(() => {
      Route.view('', 'pecas/index').name('pecas.index')
      Route.view('novo', 'pecas/novo').name('pecas.novo')
      Route.view(':id/editar/:tab?', 'pecas/editar').name('pecas.editar')
    })

  Route.view('/pesquisa-satisfacao', 'layouts/default')
    .children(() => {
      Route.view('', 'desenvolvimento/index').name('pesquisa-satisfacao.index')
      Route.view('novo', 'desenvolvimento/novo').name('pesquisa-satisfacao.novo')
      Route.view(':id/editar/:tab?', 'desenvolvimento/editar').name('pesquisa-satisfacao.editar')
      Route.view('relatorio', 'pesquisa-satisfacao/relatorio').name('pesquisa-satisfacao.relatorio')
    })

  Route.view('/projetos-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'projetos-categorias/index').name('projetos-categorias.index')
      Route.view('novo', 'projetos-categorias/novo').name('projetos-categorias.novo')
      Route.view(':id/editar/:tab?', 'projetos-categorias/editar').name('projetos-categorias.editar')
    })

  Route.view('/projetos', 'layouts/default')
    .children(() => {
      Route.view('', 'projetos/index').name('projetos.index')
      Route.view('novo', 'projetos/novo').name('projetos.novo')
      Route.view(':id/editar/:tab?', 'projetos/editar').name('projetos.editar')
      Route.view('relatorio', 'projetos/relatorio').name('projetos.relatorio')
    })

  Route.view('/residuos', 'layouts/default')
    .children(() => {
      Route.view('relatorio', 'residuos/relatorio').name('residuos.relatorio')
    })

  Route.view('/remessas', 'layouts/default')
    .children(() => {
      Route.view('', 'remessas/index').name('remessas.index')
      Route.view('novo', 'remessas/novo').name('remessas.novo')
      Route.view(':id/editar/:tab?', 'remessas/editar').name('remessas.editar')
    })

  Route.view('/retornos', 'layouts/default')
    .children(() => {
      Route.view('', 'retornos/index').name('retornos.index')
      Route.view('novo', 'retornos/novo').name('retornos.novo')
      Route.view(':id/editar/:tab?', 'retornos/editar').name('retornos.editar')
    })

  Route.view('/servicos-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'servicos-categorias/index').name('servicos-categorias.index')
      Route.view('novo', 'servicos-categorias/novo').name('servicos-categorias.novo')
      Route.view(':id/editar/:tab?', 'servicos-categorias/editar').name('servicos-categorias.editar')
    })

  Route.view('/servicos', 'layouts/default')
    .children(() => {
      Route.view('', 'servicos/index').name('servicos.index')
      Route.view('novo', 'servicos/novo').name('servicos.novo')
      Route.view(':id/editar/:tab?', 'servicos/editar').name('servicos.editar')
    })

  Route.view('/telefones-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'telefones-categorias/index').name('telefones-categorias.index')
      Route.view('novo', 'telefones-categorias/novo').name('telefones-categorias.novo')
      Route.view(':id/editar/:tab?', 'telefones-categorias/editar').name('telefones-categorias.editar')
    })

  Route.view('/textos-categorias', 'layouts/default')
    .children(() => {
      Route.view('', 'textos-categorias/index').name('textos-categorias.index')
      Route.view('novo', 'textos-categorias/novo').name('textos-categorias.novo')
      Route.view(':id/editar/:tab?', 'textos-categorias/editar').name('textos-categorias.editar')
    })

  Route.view('/textos', 'layouts/default')
    .children(() => {
      Route.view('', 'textos/index').name('textos.index')
      Route.view('novo', 'textos/novo').name('textos.novo')
      Route.view(':id/editar/:tab?', 'textos/editar').name('textos.editar')
    })

  Route.view('/transportadores', 'layouts/default')
    .children(() => {
      Route.view('', 'transportadores/index').name('transportadores.index')
      Route.view('novo', 'transportadores/novo').name('transportadores.novo')
      Route.view(':id/editar/:tab?', 'transportadores/editar').name('transportadores.editar')
    })

  Route.view('/usuarios', 'layouts/default')
    .children(() => {
      Route.view('', 'usuarios/index').name('usuarios.index')
      Route.view('novo', 'usuarios/novo').name('usuarios.novo')
      Route.view(':id/editar/:tab?', 'usuarios/editar').name('usuarios.editar')
    })

  Route.view('*', '404')
})

Route.view('/login', 'layouts/login')
  .guard(web)
  .children(() => {
    Route.view('', 'login/index').name('app.login').guard(guest)
  })

export default Route.all()
