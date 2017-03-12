<?php

class AdministradoresCondominiosTelefones_Db extends Erp_Db_Table {

    protected $_name = 'administradores_condominios_telefones';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
