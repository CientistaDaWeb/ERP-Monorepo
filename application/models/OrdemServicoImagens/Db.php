<?php

class OrdemServicoImagens_DB extends Erp_Db_Table {

    protected $_name = 'ordem_servico_imagens';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}