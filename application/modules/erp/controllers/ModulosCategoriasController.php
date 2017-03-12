<?php

class Erp_ModulosCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ModulosCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('ModulosCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}