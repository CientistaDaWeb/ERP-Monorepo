<?php

class TelefonesCategorias_Db extends Erp_Db_Table {

    protected $_name = 'telefones_categorias';
    protected $_dependenceTables = array('ClientesTelefones');

}