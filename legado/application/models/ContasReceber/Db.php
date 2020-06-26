<?php

class ContasReceber_Db extends Erp_Db_Table {

    protected $_name = 'contas_receber';
    protected $_referenceMap = array(
        'Orcamento' => array(
            'refTableClass' => 'Orcamentos_Db',
            'refColumns' => array('id'),
            'columns' => array('orcamento_id')
        ),
        'Forma' => array(
            'refTableClass' => 'FormasPagamento_Db',
            'refColumns' => array('id'),
            'columns' => array('forma_pagamento_id')
        ),
        'Empresa' => array(
            'refTableClass' => 'Empresas_Db',
            'refColumns' => array('id'),
            'columns' => array('empresa_id')
        ),
        'Remessa' => array(
            'refTableClass' => 'Remessas_Db',
            'refColumns' => array('id'),
            'columns' => array('remessa_id')
        ),
        'Retorno' => array(
            'refTableClass' => 'Retornos_Db',
            'refColumns' => array('id'),
            'columns' => array('retorno_id')
        )
    );
    public $_campos = array(
        'id' => array(
            'type' => 'WS_Form_Element_Hidden',
        ),
        'empresa_id' => array(
            'type' => 'WS_Form_Element_Hidden',
        ),
        'orcamento_id' => array(
            'type' => 'WS_Form_Element_Hidden',
        ),
        'forma_pagamento_id' => array(
            'type' => 'WS_Form_Element_Select',
            'reference' => 'FormasPagamento::FetchPairs()'
        ),
        'remessa_id' => array(
            'type' => 'WS_Form_Element_Select',
            'default' => NULL,
        ),
        'retorno_id' => array(
            'type' => 'WS_Form_Element_Select',
            'default' => NULL,
        ),
        'data_vencimento' => array(
            'type' => 'WS_Form_Element_Date',
            'adjust' => 'date'
        ),
        'valor' => array(
            'type' => 'WS_Form_Element_Money',
            'adjust' => 'money',
        ),
        'data_pagamento' => array(
            'type' => 'WS_Form_Element_Date',
            'default' => NULL,
            'adjust' => 'date',
        ),
        'valor_pago' => array(
            'type' => 'WS_Form_Element_Money',
            'default' => NULL,
            'adjust' => 'money',
        )
    );
    public $_viewCampos = array(
        'id' => 'Código',
        'cliente' => 'Cliente',
        'data_vencimento' => 'Vencimento',
        'valor' => 'Valor',
        'data_pagamento' => 'Data do Pagamento',
        'valor_pago' => 'Valor Pago',
        'empresa' => 'Empresa',
    );
    public $_searchCampos = array(
        'id',
        'orcamento_id',
        'c.razao_social',
        'e.razao_social',
        'valor',
        'valor_pago',
        'data_vencimento',
        'data_pagamento',
    );

}
