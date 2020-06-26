<?php

class Erp_IndexController extends Erp_Controller_Action {

    public function indexAction() {

        $CRModel = new ContasReceber_Model();
        $CPModel = new ContasPagar_Model();
        $CRMModel = new ClientesCrm_Model();
        $OSModel = new OrdensServico_Model();
        $OrcamentosModel = new Orcamentos_Model();
        $AgendaModel = new UsuariosCompromissos_Model();
        $ContratosModel = new Contratos_Model();
        $UsuariosModel = new Usuarios_Model();
        $ProjetosModel = new Projetos_Model();

        $usuario_id = '';
        $auth = new WS_Auth('erp');
        $user = $auth->getIdentity();
        if ($user->papel != 'A'):
            if ($user->id != 14):
                $usuario_id = $user->id;
            endif;
        endif;

        /* Usuarios */
        $faltantes = $UsuariosModel->faltantes();
        $this->view->faltantes = $faltantes;

        /* Contas a Receber */
        $this->view->tituloContasReceber = $CRModel->getOption('plural');

        $contasReceberAtrasadas = $CRModel->contasAtrasadas();
        $this->view->contasReceberAtrasadas = $contasReceberAtrasadas;

        $contasReceberVencendo = $CRModel->contasVencendo();
        $this->view->contasReceberVencendo = $contasReceberVencendo;

        /* Contas a Pagar */
        $this->view->tituloContasPagar = $CPModel->getOption('plural');

        $contasPagarAtrasadas = $CPModel->contasAtrasadas();
        $this->view->contasPagarAtrasadas = $contasPagarAtrasadas;

        $contasPagarVencendo = $CPModel->contasVencendo();
        $this->view->contasPagarVencendo = $contasPagarVencendo;

        /* Ordens de Serviço */
        $this->view->tituloOrdensServico = $OSModel->getOption('plural');

        $OSAtrasadas = $OSModel->osAtrasadas();
        $this->view->OSAtrasadas = $OSAtrasadas;

        $OSVencendo = $OSModel->osVencendo();
        $this->view->OSVencendo = $OSVencendo;

        /* Atendimentos */
        $this->view->tituloAtendimentos = $CRMModel->getOption('plural');

        $atendimentos = $CRMModel->atendimentosAbertos();
        $this->view->atendimentos = $atendimentos;

        /* Orçamentos */
        $this->view->tituloOrcamentos = $OrcamentosModel->getOption('plural');

        $divergencias = $OrcamentosModel->divergencias();
        $this->view->divergencias = $divergencias;

        $orcamentos = $OrcamentosModel->orcamentosAbertos();
        $this->view->orcamentos = $orcamentos;

        /* Agenda */
        $this->view->tituloAgenda = $AgendaModel->getOption('plural');

        $agenda = $AgendaModel->compromissos($usuario_id);
        $this->view->compromissos = $agenda;

        /* Contratos */
        $this->view->tituloContrato = $ContratosModel->getOption('plural') . ' vencendo/vencidos!';

        $contratos = $ContratosModel->contratosEncerrando();
        $this->view->contratos = $contratos;

        /* Projetos */
        $this->view->tituloProjetos = 'Projetos';

        $projetos_ppci = $ProjetosModel->ppci_abertos();
        $this->view->projetos_ppci = $projetos_ppci;

        $projetos_hidro = $ProjetosModel->hidro_abertos();
        $this->view->projetos_hidro = $projetos_hidro;
    }

    public function testeAction() {
    }

}

