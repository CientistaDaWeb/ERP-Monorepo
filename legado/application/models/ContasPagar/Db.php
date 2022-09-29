<?php

class ContasPagar_Db extends Erp_Db_Table {

    protected $_name = 'contas_pagar';
    protected $_referenceMap = array(
        'Categoria' => array(
            'refTableClass' => 'ContasPagarCategorias_Db',
            'refColumns' => array('id'),
            'columns' => array('categoria_id')
        ),
        'Fornecedor' => array(
            'refTableClass' => 'Fornecedores_Db',
            'refColumns' => array('id'),
            'columns' => array('fornecedor_id')
        ),
        'FormaPagamento' => array(
            'refTableClass' => 'FormasPagamento_Db',
            'refColumns' => array('id'),
            'columns' => array('forma_pagamento_id')
        ),
        'Empresa' => array(
            'refTableClass' => 'Empresas_Db',
            'refColumns' => array('id'),
            'columns' => array('empresa_id')
        )
    );
}
