<?php

class Erp_ServicosCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ServicosCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('ServicosCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}