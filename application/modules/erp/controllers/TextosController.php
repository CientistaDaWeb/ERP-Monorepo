<?php

class Erp_TextosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Textos_Model();
        $this->form = WS_Form_Generator::generateForm('Textos', $this->model->getFormFields());
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

    public function pegatextoAction() {
        $id = $this->_getParam('id');
        $item = $this->model->find($id);
        echo $item['descricao'];
        exit();
    }

}