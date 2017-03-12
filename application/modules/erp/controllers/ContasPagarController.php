<?php

class Erp_ContasPagarController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasPagar_Model();
        $this->form = WS_Form_Generator::generateForm('ContasPagar', $this->model->getFormFields());
        $this->actions['pay'] = 'btPay';
        parent::init();
    }

    public function indexAction(){
        $this->view->modal = true;
        parent::indexAction();
    }


    public function formularioAction() {
        parent::formularioAction();
    }

    public function pagarAction() {
        $this->model->setFormFieldsPagar();
        $this->form = WS_Form_Generator::generateForm('ContasPagarPagar', $this->model->getFormFields());
        $this->options['linkUpdate'] = '/'.$this->module.'/'.$this->controller.'/pagar/'.$this->_getParam('id');
        parent::formularioAction();
        $this->view->data = $this->model->find($this->view->data['id']);
    }

}