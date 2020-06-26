<?php

class Modulos_Db extends Erp_Db_Table {

    protected $_name = 'modulos';
    protected $_primary = 'id';
    protected $_referenceMap = array(
        'Categoria' => array(
            'refTableClass' => 'ModulosCategorias_Db',
            'refColumns' => array('id'),
            'columns' => array('categoria_id')
        )
    );

}
