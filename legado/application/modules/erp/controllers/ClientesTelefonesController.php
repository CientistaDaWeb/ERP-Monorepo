<?php

class Erp_ClientesTelefonesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ClientesTelefones_Model();
        $this->form = WS_Form_Generator::generateForm('ClientesTelefones', $this->model->getFormFields());
        parent::init();
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $cliente_id = $this->_getParam('parent_id');
        if ($this->_hasParam('cliente_id')):
            $cliente_id = $this->_getParam('cliente_id');
        endif;
        if (!empty($cliente_id)):
            $this->model->_params['cliente_id'] = $cliente_id;
            $padrao = $this->_getParam('padrao');
            if ($padrao == 'S'):
                $this->model->zeraPadrao($cliente_id);
            endif;
        endif;


        parent::formularioAction();
    }

}