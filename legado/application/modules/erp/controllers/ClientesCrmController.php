<?php

class Erp_ClientesCrmController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ClientesCrm_Model();
        $this->model->_buttons['convert'] = 'Converter em Compromisso';
        $this->form = WS_Form_Generator::generateForm('ClientesCrm', $this->model->getFormFields());
        parent::init();
    }

    public function clienteAction() {
        $cliente_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorCliente($cliente_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $cliente_id = $this->_getParam('parent_id');
        if (!empty($cliente_id)):
            $this->model->_params['cliente_id'] = $cliente_id;
        endif;

        $auth = new WS_Auth('erp');
        $usuario = $auth->getIdentity();
        if (!$this->_hasParam('usuario_id')):
            $this->model->_params['usuario_id'] = $usuario->id;
        endif;

        parent::formularioAction();
    }

}