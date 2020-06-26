<?php

class Erp_AditivosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Aditivos_Model();
        $this->form = WS_Form_Generator::generateForm('Aditivos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}
