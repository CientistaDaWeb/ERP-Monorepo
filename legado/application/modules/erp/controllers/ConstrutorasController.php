<?php

class Erp_ConstrutorasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Construtoras_Model();
        $this->form = WS_Form_Generator::generateForm('Construtoras', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}