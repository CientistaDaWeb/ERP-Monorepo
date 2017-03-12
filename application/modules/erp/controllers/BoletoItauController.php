<?php

class ERP_BoletoItauController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $id = $this->_getParam('id');
        $action = $this->_request->getActionName();
        if ($action != 'imprimir'):
            if (!empty($id)):
                $this->id = base64_decode($id);
            else:
                echo 'Informe o código!';
                exit();
            endif;
        endif;

        // FUNÇÕES
        // Algumas foram retiradas do Projeto PhpBoleto e modificadas para atender as particularidades de cada banco
        include("BoletoItau/functions.php");
    }

    public function boletoAction() {
        $ContasReceberModel = new ContasReceber_Model();
        $boleto = $ContasReceberModel->buscarParaBoleto($this->id);
        if (!empty($boleto['id'])):
            $boletos[] = $boleto;
            include("BoletoItau/layout.php");
        endif;
    }

    public function remessaAction() {
        $ContasReceberModel = new ContasReceber_Model();
        $contas = $ContasReceberModel->buscarPorRemessa($this->id);
        foreach ($contas AS $conta):
            $boleto = $ContasReceberModel->buscarParaBoleto($conta['id']);
            if (!empty($boleto['id'])):
                $boletos[] = $boleto;
            endif;
        endforeach;
        include("BoletoItau/layout.php");
    }

    public function imprimirAction() {
        $ContasReceberModel = new ContasReceber_Model();
        $boleto_id = $this->_getParam('boleto_id');
        foreach ($boleto_id AS $id):
            $boleto = $ContasReceberModel->buscarParaBoleto($id);
            if (!empty($boleto['id'])):
                $boletos[] = $boleto;
            endif;
        endforeach;
        include("BoletoItau/layout.php");
    }

    public function cteAction() {
        $this->model = new PesquisaSatisfacao_Model();
        $ContasReceberModel = new ContasReceber_Model();
        $contas = $ContasReceberModel->buscaPorCte($this->id);
        foreach ($contas AS $conta):
            $boleto = $ContasReceberModel->buscarParaBoleto($conta['id']);
            if (!empty($boleto['id'])):
                $boletos[] = $boleto;
            endif;
        endforeach;

        if ($this->_request->getParam('print')):
            $escondeinfo = true;
        endif;

        $mostra_pesquisa = false;

        $certificado = $this->model->buscaCertificadoPorCte($this->id);
        $certificado_id = $certificado['id'];
        $this->model->_formFields['certificado_id']['value'] = $certificado['id'];
        $this->form = $pesquisaForm = WS_Form_Generator::generateForm('PesquisaSatisfacao', $this->model->getFormFields());
        if ($this->_request->isPost()):
            if ($this->form->isValid($this->_request->getPost())) :
                $data = $this->form->getValues();
                unset($data['id']);
                $data['data'] = date('Y-m-d');
                $data['created'] = date('Y-m-d H:i:s');
                $id = $this->model->_db->insert($data);
            endif;
        endif;

        $jarespondeu = $this->model->buscaPorCte($this->id);
        if (!$jarespondeu):
            $mostra_pesquisa = true;
        endif;

        $mostra_pesquisa = false;

        require_once("BoletoItau/layout.php");
    }
    public function cteAcqualifeAction() {
        $this->model = new PesquisaSatisfacao_Model();
        $ContasReceberModel = new ContasReceber_Model();
        $contas = $ContasReceberModel->buscaPorCteAcqualife($this->id);
        foreach ($contas AS $conta):
            $boleto = $ContasReceberModel->buscarParaBoleto($conta['id']);
            if (!empty($boleto['id'])):
                $boletos[] = $boleto;
            endif;
        endforeach;

        if ($this->_request->getParam('print')):
            $escondeinfo = true;
        endif;

        $mostra_pesquisa = false;

        $certificado = $this->model->buscaCertificadoPorCteAcqualife($this->id);
        $certificado_id = $certificado['id'];
        $this->model->_formFields['certificado_id']['value'] = $certificado['id'];
        $this->form = $pesquisaForm = WS_Form_Generator::generateForm('PesquisaSatisfacao', $this->model->getFormFields());
        if ($this->_request->isPost()):
            if ($this->form->isValid($this->_request->getPost())) :
                $data = $this->form->getValues();
                unset($data['id']);
                $data['data'] = date('Y-m-d');
                $data['created'] = date('Y-m-d H:i:s');
                $id = $this->model->_db->insert($data);
            endif;
        endif;

        $jarespondeu = $this->model->buscaPorCteAcqualife($this->id);
        if (!$jarespondeu):
            $mostra_pesquisa = true;
        endif;

        $mostra_pesquisa = false;

        require_once("BoletoItau/layout.php");
    }

}
