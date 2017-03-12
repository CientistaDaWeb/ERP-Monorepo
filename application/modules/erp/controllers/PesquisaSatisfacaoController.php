<?php

class Erp_PesquisaSatisfacaoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new PesquisaSatisfacao_Model();
        unset($this->buttons['add']);
        parent::init();
    }


}
