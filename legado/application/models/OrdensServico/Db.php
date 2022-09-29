<?php

class OrdensServico_Db extends Erp_Db_Table {

    protected $_name = 'ordens_servico';
    protected $_dependenceTables = array('OrdemServicoServicos', 'Mtr');
    protected $_referenceMap = array(
        'Orcamento' => array(
            'refTableClass' => 'Orcamentos',
            'refColumns' => array('id'),
            'columns' => array('orcamento_id')
        ),
        'Empresa' => array(
            'refTableClass' => 'Empresas',
            'refColumns' => array('id'),
            'columns' => array('empresa_id')
        )
    );

}
