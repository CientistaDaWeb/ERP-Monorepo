<?php

class Erp_RelatorioResiduosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Servicos_Model();
        parent::init();
        $this->model->_title = 'Relatório de Residuos';
    }

    public function indexAction() {
        $data['servico_id'] = '';
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial');
            endif;

            $items = $this->model->relatorioResiduos($data);
            $this->view->items = $items;

            $OrdensServicoModel = new OrdensServico_Model();
            $faturado = $OrdensServicoModel->buscaFaturamento($data);
            $this->view->faturado = $faturado['faturado'];
        endif;

        $this->view->data = $data;
    }

}