<?php

class Erp_BensController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Bens_Model();
        $this->form = WS_Form_Generator::generateForm('Bens', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
        $this->view->items = $this->model->basicSearch();
    }

    public function formularioAction() {
        $this->options['noForm'] = true;
        parent::formularioAction();
    }

}