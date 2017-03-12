<?php

class Pecas_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Pecas_Db();
        $this->_pair = 'nome';
        $this->_title = 'Gerenciador de Peças';
        $this->_singular = 'Peça';
        $this->_plural = 'Peças';
        $this->_layoutList = 'basic';
        $this->_primary = 'p.id';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('p' => 'pecas'), array('id', 'nome'))
                ->order('nome');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => 'pecas'), array('*'))
                ->joinLeft(array('mp' => 'manutencoes_pecas'), 'p.id = mp.peca_id', array('manutencoes' => 'COUNT(mp.id)'))
                ->group('p.id');
        $this->_basicSearch->__toString();
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'c.nome' => 'text',
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
            'manutencoes' => 'Manutenções',
        );
    }

}