import Vue from 'vue'
import Vuex from 'vuex'

import abastecimentos from './abastecimentos'
import aditivos from './aditivos'
import agenda from './agenda'
import administradoresCondominio from './administradores-condominio'
import arquitetos from './arquitetos'
import bancos from './bancos'
import bens from './bens'
import caminhoes from './caminhoes'
import certificados from './certificados'
import cfops from './cfops'
import clientes from './clientes'
import clientesArquivos from './clientes-arquivos'
import clientesCategorias from './clientes-categorias'
import clientesCrm from './clientes-crm'
import clientesEnderecos from './clientes-enderecos'
import clientesTelefones from './clientes-telefones'
import contasReceber from './contas-receber'
import contasPagar from './contas-pagar'
import contasPagarCategorias from './contas-pagar-categorias'
import construtoras from './construtoras'
import contratos from './contratos'
import ctes from './ctes'
import ctesAcqualife from './ctes-acqualife'
import ctesAcquaservicos from './ctes-acquaservicos'
import empresas from './empresas'
import empresasArquivosCategorias from './empresas-arquivos-categorias'
import estados from './estados'
import enderecosCategorias from './enderecos-categorias'
import formasPagamento from './formas-pagamento'
import fornecedores from './fornecedores'
import fornecedoresCategorias from './fornecedores-categorias'
import manutencoes from './manutencoes'
import modulos from './modulos'
import modulosCategorias from './modulos-categorias'
import mtrs from './mtrs'
import municipios from './municipios'
import notasFiscais from './notas-fiscais'
import notasProjetos from './notas-projetos'
import orcamentos from './orcamentos'
import orcamentosServicos from './orcamentos-servicos'
import ordensServico from './ordens-servico'
import pecas from './pecas'
import projetos from './projetos'
import projetosCategorias from './projetos-categorias'
import retornos from './retornos'
import relatorios from './relatorios'
import remessas from './remessas'
import servicos from './servicos'
import servicosCategorias from './servicos-categorias'
import telefonesCategorias from './telefones-categorias'
import textos from './textos'
import textosCategorias from './textos-categorias'
import transportadores from './transportadores'
import users from './users'
import usuarios from './usuarios'
import usuariosCompromissos from './usuarios-compromissos'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    abastecimentos,
    aditivos,
    administradoresCondominio,
    agenda,
    arquitetos,
    bancos,
    bens,
    caminhoes,
    certificados,
    cfops,
    clientes,
    clientesArquivos,
    clientesCategorias,
    clientesCrm,
    clientesEnderecos,
    clientesTelefones,
    contasReceber,
    contasPagar,
    contasPagarCategorias,
    construtoras,
    contratos,
    ctes,
    ctesAcqualife,
    ctesAcquaservicos,
    empresas,
    empresasArquivosCategorias,
    estados,
    enderecosCategorias,
    formasPagamento,
    fornecedores,
    fornecedoresCategorias,
    manutencoes,
    modulos,
    modulosCategorias,
    mtrs,
    municipios,
    notasFiscais,
    notasProjetos,
    orcamentos,
    orcamentosServicos,
    ordensServico,
    pecas,
    projetos,
    projetosCategorias,
    relatorios,
    remessas,
    retornos,
    servicos,
    servicosCategorias,
    telefonesCategorias,
    textos,
    textosCategorias,
    transportadores,
    users,
    usuarios,
    usuariosCompromissos
  }
})

export default store
