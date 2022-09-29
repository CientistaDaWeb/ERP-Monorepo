<?php

class OrdensServicoServicos_Db extends Erp_Db_Table {

    protected $_name = 'ordens_servico_servicos';
    protected $_referenceMap = array(
        'OrdemServico' => array(
            'refTableClass' => 'OrdensServico',
            'refColumns' => array('id'),
            'columns' => array('ordem_servico_id')
        ),
        'Servico' => array(
            'refTableClass' => 'Servicos',
            'refColumns' => array('id'),
            'columns' => array('servico_id')
        )
    );

}
