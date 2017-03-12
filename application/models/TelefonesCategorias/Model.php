<?php

class TelefonesCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new TelefonesCategorias_Db();
        $this->_pair = 'categoria';
        $this->_title = 'Gerenciador de Categorias de Telefones';
        $this->_singular = 'Categoria de Telefones';
        $this->_plural = 'Categorias de Telefones';
        $this->_layoutList = 'basic';
        $this->_primary = 'tc.id';


        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('tc' => 'telefones_categorias'), array('id', 'categoria'))
                ->order('categoria');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('tc' => 'telefones_categorias'), array('id', 'categoria'))
                ->joinLeft(array('ct' => 'clientes_telefones'), 'tc.id = ct.categoria_id', array('telefones' => 'count(ct.id)'))
                ->group('tc.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'categoria' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'telefones' => 'Telefones'
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
