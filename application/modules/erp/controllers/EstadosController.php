<?php

class Erp_EstadosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Estados_Model();
        $this->form = WS_Form_Generator::generateForm('Estados',$this->model->getFormFields());
        unset($this->buttons['del']);
        unset($this->actions['delete']);
        parent::init();
    }

    public function formularioAction() {
        parent::formularioAction();
    }

}