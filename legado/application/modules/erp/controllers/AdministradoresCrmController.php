<?php

class Erp_AdministradoresCrmController extends Erp_Controller_Action {

    public function init() {
        $this->model = new AdministradoresCrm_Model();
        $this->model->_buttons['convert'] = 'Converter em Compromisso';
        $this->form = WS_Form_Generator::generateForm('AdministradoresCrm', $this->model->getFormFields());
        parent::init();
    }

    public function administradorAction() {
        $administrador_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorAdministrador($administrador_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $administrador_id = $this->_getParam('parent_id');
        if (!empty($administrador_id)):
            $this->model->_params['administrador_id'] = $administrador_id;
        endif;

        parent::formularioAction();
    }

}