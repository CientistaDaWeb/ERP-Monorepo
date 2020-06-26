<?php

class Estados_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Estados_Db();
        $this->_pair = 'estado';
        $this->_title = 'Gerenciador de Estados';
        $this->_singular = 'Estado';
        $this->_plural = 'Estados';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from('estados', array('id', 'estado'));
        return $db->fetchPairs($query);
    }

    public function getEstadosPair() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('e' => 'estados'), array('uf', 'estado'));
        return $db->fetchPairs($sql);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'estado' => array(
                'label' => 'Estado',
                'type' => 'Text',
                'required' => true
            ),
            'uf' => array(
                'label' => 'UF',
                'type' => 'Text',
                'required' => true
            ),
            'codigo' => array(
                'label' => 'Código IBGE',
                'type' => 'Number',
                'required' => true
            ),
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'estado' => 'text',
            'uf' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'estado' => 'Estado',
            'uf' => 'UF'
        );
    }

}