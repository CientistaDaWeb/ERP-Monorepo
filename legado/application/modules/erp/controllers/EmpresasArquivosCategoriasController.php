<?php

class Erp_EmpresasArquivosCategoriasController extends Erp_Controller_Action {

    public function init() {
        $this->model = new EmpresasArquivosCategorias_Model();
        $this->form = WS_Form_Generator::generateForm('EmpresasArquivosCategorias', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}