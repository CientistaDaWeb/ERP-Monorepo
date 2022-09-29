<?php

class Erp_TelefonesCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new TelefonesCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('TelefonesCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        parent::formularioAction();
    }

}