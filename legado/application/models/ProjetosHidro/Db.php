<?php

class ProjetosHidro_DB extends Erp_Db_Table {

    protected $_name = 'projetos_hidro';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}