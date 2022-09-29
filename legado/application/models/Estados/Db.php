<?php

class Estados_Db extends Erp_Db_Table {

    protected $_name = 'estados';
    protected $_dependenceTables = array('ClientesEnderecos_Db');

}