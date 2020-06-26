<?php

class Aditivos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Aditivos_Db();
        $this->_pair = 'nome';
        $this->_title = 'Gerenciador de Aditivos';
        $this->_singular = 'Aditivo';
        $this->_plural = 'Aditivos';
        $this->_layoutList = 'basic';
        $this->_primary = 'a.id';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('a' => 'aditivos'), array('id', 'nome'))
                ->order('nome');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => 'aditivos'), array('*'))
                ->joinLeft(array('ab' => 'abastecimentos'), 'a.id = ab.aditivo_id', array('abastecimentos' => 'COUNT(ab.id)'))
                ->group('a.id');
        $this->_basicSearch->__toString();
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'a.nome' => 'text',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'label' => 'Nome',
                'type' => 'Text',
                'required' => true
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'abastecimentos' => 'Abastecimentos',
        );
    }

}