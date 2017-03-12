<?php

class Cfops_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Cfops_Db();
        $this->_pair = 'descricao';
        $this->_title = 'Gerenciador de Cfops';
        $this->_singular = 'Cfop';
        $this->_plural = 'Cfops';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'cfops'), array('*'))
        ;
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from('cfops', array('id', 'nome' => 'CONCAT(codigo," - ",descricao)'))
                ->order('nome');
        return $db->fetchPairs($query);
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'codigo' => 'ASC'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'descricao' => array(
                'label' => 'Descrição',
                'type' => 'Text',
                'required' => true
            ),
            'codigo' => array(
                'label' => 'Código',
                'type' => 'Number',
                'required' => true,
            ),
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'descricao' => 'text',
            'codigo' => 'text',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'codigo' => 'Código',
            'descricao' => 'Descrição',
        );
    }

}