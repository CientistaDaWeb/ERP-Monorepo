<?php

class FornecedoresArquivos_Db extends Erp_Db_Table {

    protected $_name = 'fornecedores_arquivos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
