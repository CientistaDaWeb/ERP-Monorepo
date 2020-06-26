<?php

class Erp_UsuariosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Usuarios_Model();
        $this->form = WS_Form_Generator::generateForm('Usuarios', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        parent::formularioAction();
    }

}