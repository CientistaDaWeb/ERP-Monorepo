<?php

class Erp_AdministradoresCondominiosTelefonesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new AdministradoresCondominiosTelefones_Model();
        $this->form = WS_Form_Generator::generateForm('AdministradoresCondominiosTelefones', $this->model->getFormFields());
        parent::init();
    }

    public function administradorAction() {
        $administrador_condominio_id = $this->_getParam('parent_id');
        $items = $this->model->buscarPorAdministrador($administrador_condominio_id);
        $this->view->items = $items;
    }

    public function formularioAction() {
        $administrador_condominio_id = $this->_getParam('parent_id');
        if ($this->_hasParam('administrador_condominio_id')):
            $administrador_condominio_id = $this->_getParam('administrador_condominio_id');
        endif;
        if (!empty($administrador_condominio_id)):
            $this->model->_params['administrador_condominio_id'] = $administrador_condominio_id;
            $padrao = $this->_getParam('padrao');
            if ($padrao == 'S'):
                $this->model->zeraPadrao($administrador_condominio_id);
            endif;
        endif;


        parent::formularioAction();
    }

}