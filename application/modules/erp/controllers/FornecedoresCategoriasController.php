<?php

class Erp_FornecedoresCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new FornecedoresCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('FornecedoresCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}