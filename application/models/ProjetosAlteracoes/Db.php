<?php

class ProjetosAlteracoes_DB extends Erp_Db_Table {

    protected $_name = 'projetos_alteracoes';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}