<?php

class Municipios_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Municipios_Db();
        $this->_pair = 'estado';
        $this->_title = 'Gerenciador de Municípios';
        $this->_singular = 'Município';
        $this->_plural = 'Municipios';
        $this->_layoutList = 'basic';
        $this->_primary = 'm.id';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'municipios'), array('*'))
                ->joinInner(array('e' => 'estados'), 'e.id = m.estado_id', array('uf'));
    }

    public static function fetchPair($estado_id = NULL) {
        $db = WS_Model::getDefaultAdapter();
        $query = $db->select()
                ->from('municipios', array('id', 'nome'))
                ->order('nome');
        if (!empty($estado_id)):
            $query->where('estado_id = ?', $estado_id);
        endif;
        return $db->fetchPairs($query);
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'nome' => 'ASC'
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
            'estado_id' => array(
                'label' => 'Estado',
                'type' => 'Select',
                'options' => Estados_Model::fetchPair(),
                'required' => true,
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
            'nome' => 'text',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Município',
            'codigo' => 'Código IBGE',
            'uf' => 'Estado',
        );
    }

}