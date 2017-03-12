<?php

class ProjetosArquivos_DB extends Erp_Db_Table {

    protected $_name = 'projetos_arquivos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}