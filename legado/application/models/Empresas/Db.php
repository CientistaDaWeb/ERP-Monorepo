<?php

class Empresas_Db extends Erp_Db_Table {

    protected $_name = 'empresas';
    protected $_dependenceTables = array('Orcamentos_Db', 'ContasReceber_Db', 'ContasPagar_Db', 'OrdensServico_Db');
    protected $_referenceMap = array(
        'Estado' => array(
            'refTableClass' => 'Estados_Db',
            'refColumns' => array('id'),
            'columns' => array('estado_id')
        )
    );
}
