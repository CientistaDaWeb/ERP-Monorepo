<?php

class Erp_RelatorioClientesCondominioController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Clientes_Model();
        parent::init();
        $this->model->_title = 'Relatório de Clientes por Administrador de Condomínio';
    }

    public function indexAction() {
        $data['administrador_id'] = '';
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            $items = $this->model->relatorioAdministradores($data['administrador_id']);
            $this->view->items = $items;
        endif;
        $this->view->data = $data;
    }

    public function pdfAction() {
        if ($this->_request->isPost()):
            $data = $this->_getAllParams();
            $document = $this->model->montaRelatorio($data, 'pdf');
            $this->getResponse()
                    ->setHeader('Content-Disposition', 'attachment; filename=Relatório-de-Atendimentos')
                    ->setHeader('Content-type', 'application/x-pdf')
                    ->setBody($document);
        endif;
    }

}