<?php

class Erp_LogsAcessosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new WS_LogsAcessos_Model();
        parent::init();
    }

    public function indexAction() {
        $this->view->items = $this->model->listagem();
        parent::indexAction();
    }

}