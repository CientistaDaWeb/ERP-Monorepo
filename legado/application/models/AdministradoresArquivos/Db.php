<?php

class AdministradoresArquivos_Db extends Erp_Db_Table {

    protected $_name = 'administradores_arquivos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
