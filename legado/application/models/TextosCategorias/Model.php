<?php

class TextosCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new TextosCategorias_Db();
        $this->_pair = 'categoria';
        $this->_title = 'Gerenciador de Categorias de Textos';
        $this->_singular = 'Categoria de Textos';
        $this->_plural = 'Categorias de Textos';
        $this->_primary = 'tc.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('tc' => 'textos_categorias'), array('*'))
                ->joinLeft(array('t' => 'textos'), 'tc.id = t.categoria_id', array('textos' => 'COUNT(t.id)'))
                ->group('tc.id');
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('tc' => 'textos_categorias'), array('id', 'categoria'));
        return $db->fetchPairs($sql);
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'categoria' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'textos' => 'Textos'
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

    public function setOrderFields() {
        $this->_orderFields = array(
            'categoria' => 'asc'
        );
    }

}
