<?php

class Erp_TemplatesCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new TemplatesCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('TemplatesCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function indexAction() {
        parent::indexAction();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}