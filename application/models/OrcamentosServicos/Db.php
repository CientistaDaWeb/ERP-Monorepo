<?php

class OrcamentosServicos_Db extends Erp_Db_Table {

    protected $_name = 'orcamentos_servicos';
    protected $_dependenceTables = array();
    protected $_referenceMap = array(
        'Orcamento' => array(
            'refTableClass' => 'Orcamentos',
            'refColumns' => array('id'),
            'columns' => array('orcamento_id')
        ),
        'Servico' => array(
            'refTableClass' => 'Servicos',
            'refColumns' => array('id'),
            'columns' => array('servico_id')
        )
    );

}