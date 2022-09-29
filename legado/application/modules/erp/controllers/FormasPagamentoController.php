<?php

class Erp_FormasPagamentoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new FormasPagamento_Model();
        $this->form = WS_Form_Generator::generateForm('FormasPAgamento', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}