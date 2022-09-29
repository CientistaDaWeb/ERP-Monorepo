<?php

class Erp_AbastecimentosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Abastecimentos_Model();
        $this->form = WS_Form_Generator::generateForm('Abastecimentos', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}