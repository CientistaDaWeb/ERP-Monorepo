<?php

class Erp_CaminhoesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Caminhoes_Model();
      $this->form = WS_Form_Generator::generateForm('Caminhoes', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}
