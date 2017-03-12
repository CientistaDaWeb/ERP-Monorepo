<?php

class Erp_LogsAlteracoesController extends Erp_Controller_Action {

    public function init() {
        $this->model = new WS_LogsAlteracoes_Model();
        parent::init();
    }

    public function indexAction() {
        $this->view->items = $this->model->listagem();
        parent::indexAction();
    }

    public function dadosAction() {
        if ($this->_hasParam('id')):
            $data = $this->model->adjustToView($this->model->find($this->_getParam('id')));
            $this->view->item = $data;
        endif;
    }

}