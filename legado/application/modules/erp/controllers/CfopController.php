<?php

class Erp_CfopController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Cfops_Model();
        $this->form = WS_Form_Generator::generateForm('Cfop', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}