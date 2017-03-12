<?php

class ClientesCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ClientesCategorias_Db();
        $this->_title = 'Gerenciador de Categorias de Módulos';
        $this->_singular = 'Categoria de Cliente';
        $this->_plural = 'Categorias de Cliente';
        $this->_primary = 'cc.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cc' => 'clientes_categorias'), array('*'))
                ->joinLeft(array('c' => 'clientes'), 'cc.id = c.categoria_id', array('clientes' => 'COUNT(c.id)'))
                ->group('cc.id');
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('cc' => 'clientes_categorias'), array('id', 'categoria'));
        return $db->fetchPairs($sql);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'categoria' => array(
                'type' => 'Text',
                'label' => 'Categoria',
                'required' => true
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'clientes' => 'Nº Clientes'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'cc.categoria' => 'text'
        );
    }

}

