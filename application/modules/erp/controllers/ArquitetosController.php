<?php

class Erp_ArquitetosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Arquitetos_Model();
        $this->form = WS_Form_Generator::generateForm('Arquitetos', $this->model->getFormFields());
        parent::init();
    }



}