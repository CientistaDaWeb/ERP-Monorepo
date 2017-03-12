<?php

class Erp_NotasProjetosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new NotasProjetos_Model();
        $this->form = WS_Form_Generator::generateForm('NotasProjetos', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}