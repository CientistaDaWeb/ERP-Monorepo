<?php

class Erp_ClientesCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ClientesCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('ClientesCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}