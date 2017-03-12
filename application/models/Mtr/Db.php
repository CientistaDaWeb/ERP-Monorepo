<?php

class Mtr_Db extends Erp_Db_Table {

    protected $_name = 'mtrs';
    protected $_title = 'Gerenciador de MTR';
    protected $_referenceMap = array(
        'OrdemServico' => array(
            'refTableClass' => 'OrdensServico',
            'refColumns' => array('id'),
            'columns' => array('ordem_servico_id')
        )
    );
}
