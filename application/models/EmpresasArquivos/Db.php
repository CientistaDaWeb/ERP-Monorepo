<?php

class EmpresasArquivos_Db extends Erp_Db_Table {

    protected $_name = 'empresas_arquivos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
