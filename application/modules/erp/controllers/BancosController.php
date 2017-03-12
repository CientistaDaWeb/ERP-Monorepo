<?php

class Erp_BancosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Bancos_Model();
        $this->form = WS_Form_Generator::generateForm('Bancos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}