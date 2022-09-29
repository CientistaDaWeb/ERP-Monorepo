<?php

class ProjetosArquitetonicos_DB extends Erp_Db_Table {

    protected $_name = 'projetos_arquitetonicos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}