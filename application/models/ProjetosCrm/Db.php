<?php

class ProjetosCrm_Db extends Erp_Db_Table {

    protected $_name = 'projetos_crm';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
