<?php

class ClientesEnderecos_Db extends Erp_Db_Table {

    protected $_name = 'clientes_enderecos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
