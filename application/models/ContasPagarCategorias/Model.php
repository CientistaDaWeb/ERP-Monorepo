<?php

class ContasPagarCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ContasPagarCategorias_Db();
        $this->_pair = 'categoria';
        $this->_title = 'Gerenciador de Categorias de Contas à Pagar';
        $this->_singular = 'Categoria de Contas à Pagar';
        $this->_plural = 'Categorias de Contas à Pagar';
        $this->_primary = 'cpc.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('cpc' => 'contas_pagar_categorias'), array('id', 'categoria'));
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cpc' => 'contas_pagar_categorias'), array('id', 'categoria'))
                ->joinLeft(array('cp' => 'contas_pagar'), 'cpc.id = cp.categoria_id', array('contas' => 'count(cp.id)'))
                ->group('cpc.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'categoria' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'contas' => 'Contas'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'categoria' => array(
                'label' => 'Categoria',
                'type' => 'Text'
            )
        );
    }

}

