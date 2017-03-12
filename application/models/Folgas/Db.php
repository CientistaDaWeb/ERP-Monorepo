<?php

class Folgas_Db extends Erp_Db_Table {

    protected $_name = 'folgas';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

}
