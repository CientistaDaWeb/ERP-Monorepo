<?php

class Erp_ContratosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Contratos_Model();
        unset($this->buttons['add']);
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function orcamentoAction() {
        $this->view->form = new Contratos_Form();
        $orcamento_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorOrcamento($orcamento_id);
        $this->view->items = $items;
    }

    public function clienteAction() {
        $this->view->form = new Contratos_Form();
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $this->form = new Contratos_Form();
        $orcamento_id = $this->_getParam('parent_id');
        if (!empty($orcamento_id)):
            $this->model->_params['orcamento_id'] = $orcamento_id;
        endif;
        parent::formularioAction();
    }

}