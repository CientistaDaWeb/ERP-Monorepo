<?php

class ProjetosAtividades_DB extends Erp_Db_Table {

    protected $_name = 'projetos_atividades';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}