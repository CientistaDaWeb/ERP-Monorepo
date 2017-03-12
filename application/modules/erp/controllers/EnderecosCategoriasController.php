<?php

class Erp_EnderecosCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new EnderecosCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('EnderecosCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}