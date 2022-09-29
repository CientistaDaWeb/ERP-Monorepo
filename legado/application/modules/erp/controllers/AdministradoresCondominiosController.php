<?php

class Erp_AdministradoresCondominiosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new AdministradoresCondominios_Model();
        $this->form = WS_Form_Generator::generateForm('AdministradoresCondominios', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}