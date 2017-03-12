<?php

class Erp_ContasPagarCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasPagarCategorias_Model();
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->form = WS_Form_Generator::generateForm('ContasPagarCategorias', $this->model->getFormFields());
        parent::formularioAction();
    }

}