<?php

class ProjetosAtividadesTempo_DB extends Erp_Db_Table {

    protected $_name = 'projetos_atividades_tempo';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}