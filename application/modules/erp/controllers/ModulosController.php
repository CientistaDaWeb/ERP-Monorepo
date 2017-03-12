<?php

class Erp_ModulosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Modulos_Model();
        $this->form = WS_Form_Generator::generateForm('Modulos', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}