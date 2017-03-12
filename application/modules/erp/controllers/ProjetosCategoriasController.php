<?php

class Erp_ProjetosCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ProjetosCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('ProjetosCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        parent::formularioAction();
    }

}