<?php

class Erp_NotasFiscaisController extends Erp_Controller_Action {

    public function init() {
        $this->model = new NotasFiscais_Model();
        $this->form = WS_Form_Generator::generateForm('NotasFiscais', $this->model->getFormFields());
        unset($this->buttons['add']);
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function orcamentoAction() {
        $orcamento_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorOrcamento($orcamento_id);
        $this->view->items = $items;
        $this->view->orcamento_id = $orcamento_id;
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $orcamento_id = $this->_getParam('parent_id');
        if (!empty($orcamento_id)):
            $this->model->_params['orcamento_id'] = $orcamento_id;
        endif;

        parent::formularioAction();
    }

}