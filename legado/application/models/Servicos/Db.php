<?php

class Servicos_Db extends Erp_Db_Table {

    protected $_name = 'servicos';
    protected $_referenceMap = array(
        'Categoria' => array(
            'refTableClass' => 'ServicosCategorias_Db',
            'refColumns' => array('id'),
            'columns' => array('categoria_id')
        )
    );

}
