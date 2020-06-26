<?php

class Erp_TransportadoresController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Transportadores_Model();
        $this->form = WS_Form_Generator::generateForm('Transportadores', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}