<?php

class Erp_ManutencaoCaminhaoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ManutencaoCaminhao_Model();
        $this->form = WS_Form_Generator::generateForm('ManutencaoCaminhao', $this->model->getFormFields());

        parent::init();
    }

    public function formularioAction() {
        $this->options['noList'] = true;
        parent::formularioAction();
    }



}
