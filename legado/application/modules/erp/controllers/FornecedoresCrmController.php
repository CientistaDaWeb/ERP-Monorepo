<?php

class Erp_FornecedoresCrmController extends Erp_Controller_Action {

    public function init() {
        $this->model = new FornecedoresCrm_Model();
        $this->model->_buttons['convert'] = 'Converter em Compromisso';
        $this->form = WS_Form_Generator::generateForm('FornecedoresCrm', $this->model->getFormFields());
        parent::init();
    }

    public function fornecedorAction() {
        $fornecedor_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorFornecedor($fornecedor_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $fornecedor_id = $this->_getParam('parent_id');
        if (!empty($fornecedor_id)):
            $this->model->_params['fornecedor_id'] = $fornecedor_id;
        endif;

        parent::formularioAction();
    }

}