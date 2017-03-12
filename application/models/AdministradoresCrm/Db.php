<?php

class AdministradoresCrm_Db extends Erp_Db_Table {

    protected $_name = 'administradores_crm';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
