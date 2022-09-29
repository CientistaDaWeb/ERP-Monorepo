<?php

class FornecedoresCrm_Db extends Erp_Db_Table {

    protected $_name = 'fornecedores_crm';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
