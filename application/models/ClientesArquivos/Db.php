<?php

class ClientesArquivos_Db extends Erp_Db_Table {

    protected $_name = 'clientes_arquivos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
