<?php

class Erp_FolgasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Folgas_Model();
        $this->form = WS_Form_Generator::generateForm('Folgas', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}