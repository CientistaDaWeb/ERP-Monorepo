<?php

class Abastecimentos_Db extends Erp_Db_Table {

    protected $_name = 'abastecimentos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
