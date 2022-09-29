<?php

class FormasPagamento_Model extends WS_Model {

    protected $_gera_remessa;

    public function __construct() {
        $this->_db = new FormasPagamento_Db();
        $this->_title = 'Gerenciador de Formas de Pagamento';
        $this->_singular = 'Forma de Pagamento';
        $this->_plural = 'Formas de Pagamento';
        $this->_primary = 'fp.id';
        $this->_layoutList = 'basic';
        $this->_gera_remessa = array(
            'N' => 'Não',
            'S' => 'Sim'
        );

        parent::__construct();
        parent::turningFemale();
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'fp.forma_pagamento' => 'text',
            'b.banco' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'forma_pagamento' => 'Forma de Pagamento',
            'banco' => 'Banco',
            'contas' => 'Nº Contas'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'banco_id' => array(
                'label' => 'Banco',
                'type' => 'Select',
                'options' => Bancos_Model::fetchPair(),
                'required' => true
            ),
            'forma_pagamento' => array(
                'label' => 'Nome da Forma de Pagamento',
                'type' => 'Text',
                'required' => true
            ),
            'gera_remessa' => array(
                'label' => 'Gera Remessa?',
                'type' => 'Select',
                'options' => $this->_gera_remessa
            )
        );
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $consulta = $db->select()
                ->from('formas_pagamento', array('id', 'forma_pagamento'))
                ->order('forma_pagamento');
        return $db->fetchPairs($consulta);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('fp' => 'formas_pagamento'), array('*'))
                ->joinInner(array('b' => 'bancos'), 'b.id = fp.banco_id', array('banco'))
                ->joinLeft(array('cr' => 'contas_receber'), 'fp.id = cr.forma_pagamento_id', array('contas' => 'count(cr.id)' ))
                ->group('fp.id');
    }

    public function buscaGeraRemessa() {
        $db = $this->getDefaultAdapter();
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('fp' => 'formas_pagamento'), array('id', 'forma_pagamento'))
                ->joinInner(array('b' => 'bancos'), 'b.id = fp.banco_id', array('banco'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa' => 'razao_social'))
                ->where('fp.gera_remessa = "S"')
                ->order('fp.forma_pagamento');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

}
