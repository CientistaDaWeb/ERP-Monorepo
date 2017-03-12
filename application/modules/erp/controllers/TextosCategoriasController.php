<?php

class Erp_TextosCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new TextosCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('TextosCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}