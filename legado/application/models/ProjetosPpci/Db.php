<?php

class ProjetosPpci_DB extends Erp_Db_Table {

    protected $_name = 'projetos_ppci';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}