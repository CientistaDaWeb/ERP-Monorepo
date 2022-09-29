<?php

class EnderecosCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new EnderecosCategorias_Db();
        $this->_title = 'Gerenciador de Categorias de Endereços';
        $this->_singular = 'Categoria de Endereços';
        $this->_plural = 'Categorias de Endereços';
        $this->_layoutList = 'basic';
        $this->_primary = 'ec.id';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from('enderecos_categorias', array('id', 'categoria'))
                ->order('categoria');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ec' => 'enderecos_categorias'), array('id', 'categoria'))
                ->joinLeft(array('ce' => 'clientes_enderecos'), 'ec.id = ce.categoria_id', array('enderecos' => 'count(ce.id)'))
                ->group('ec.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'categoria' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'enderecos' => 'Endereços'
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
