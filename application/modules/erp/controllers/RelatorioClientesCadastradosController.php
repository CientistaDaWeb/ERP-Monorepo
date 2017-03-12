<?php

class Erp_RelatorioClientesCadastradosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Clientes_Model();
        parent::init();
        $this->model->_title = 'Relatório de Clientes Cadastrados';
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            $items = $this->model->relatorioCadastrados($data);
            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

}
