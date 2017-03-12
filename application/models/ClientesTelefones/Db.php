<?php

class ClientesTelefones_Db extends Erp_Db_Table {

    protected $_name = 'clientes_telefones';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
