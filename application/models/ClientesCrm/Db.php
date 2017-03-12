<?php

class ClientesCrm_Db extends Erp_Db_Table {

    protected $_name = 'clientes_crm';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
