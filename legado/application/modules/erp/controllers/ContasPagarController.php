<?php

class Erp_ContasPagarController extends Erp_Controller_Action {

    public function init() {
        $this->model = new ContasPagar_Model();
        $this->actions['pay'] = 'btPay';

        $data = $this->_request->getParams();

        if(empty($data['id'])):
            unset($this->model->_formFields['valor_pago']);
            unset($this->model->_formFields['data_pagamento']);
            unset($this->model->_formFields['data_lancamento']);
        else:
            $item = $this->model->find($data['id']);
            if(empty($item['valor_pago'])):
                unset($this->model->_formFields['valor_pago']);
                unset($this->model->_formFields['data_pagamento']);
                unset($this->model->_formFields['data_lancamento']);
            endif;
        endif;

        $this->form = WS_Form_Generator::generateForm('ContasPagar', $this->model->getFormFields());

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