<?php

class Erp_PermissaoNegadaController extends Zend_Controller_Action {

    public function indexAction() {
        $this->view->data = $this->_getAllParams();
    }

}

