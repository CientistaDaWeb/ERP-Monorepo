<?php

class Erp_RelatorioOrcamentosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Orcamentos_Model();
        parent::init();
        $this->model->_title = 'Relatório de ' . $this->model->getOption('plural');
    }

    public function indexAction() {
        $data['data_inicial'] = date('d/m/Y', mktime(0, 0, 0, date('m') - 1, date('d'), date('Y')));
        $data['data_final'] = date('d/m/Y');
        $data['status'] = '';
        $data['usuario_id'] = '';
        $data['empresa_id'] = '';
        $data['cliente_id'] = '';

        if ($this->_request->isPost()):
            $data = $this->_getAllParams();

            /* Limita a data final da pesquisa quando não for administrador */
            $auth = new WS_Auth('erp');
            $user = $auth->getIdentity();
            if ($user->papel != 'A'):
                /* Limita a data inicial */
                $data = Erp_Date::dateLimit($data, 35, 'data_inicial');
            endif;

            $items = $this->model->relatorio($data);
            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

    public function pdfAction() {
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            $document = $this->model->montaRelatorio($data, 'pdf');
            $this->getResponse()
                    ->setHeader('Content-Disposition', 'attachment; filename=Relatorio-de-Orcamentos')
                    ->setHeader('Content-type', 'application/x-pdf')
                    ->setBody($document);
        endif;
    }

}