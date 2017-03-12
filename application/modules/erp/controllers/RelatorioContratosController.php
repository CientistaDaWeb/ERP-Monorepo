<?php

class Erp_RelatorioContratosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Contratos_Model();
        parent::init();
        $this->model->_title = 'Relatório de Contratos';
    }

    public function indexAction() {
        $data['assinatura_data_inicial'] = '';
        $data['assinatura_data_final'] = '';
        $data['encerramento_data_inicial'] = '';
        $data['encerramento_data_final'] = '';
        $data['cliente_id'] = '';
        $data['tipo_efluente'] = '';
        $data['servico_contratado'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'assinatura_data_inicial');
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'encerramento_data_inicial');
            endif;

            $items = $this->model->relatorio($data);
            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

}