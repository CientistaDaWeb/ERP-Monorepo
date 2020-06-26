<?php

class FornecedoresCategorias_Model extends WS_Model {

    public function __construct() {

        $this->_db = new FornecedoresCategorias_Db();
        $this->_pair = 'categoria';
        $this->_title = 'Gerenciador de Categorias de Fornecedores';
        $this->_singular = 'Categoria de fornecedores';
        $this->_plural = 'Categorias de fornecedores';
        $this->_primary = 'fc.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('fc'=>'fornecedores_categorias'), array('id', 'categoria'));
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('fc' => 'fornecedores_categorias'), array('*'))
                ->joinLeft(array('f' => 'fornecedores'), 'fc.id = f.categoria_id', array('fornecedores' => 'COUNT(f.id)'))
                ->group('fc.id')
                ->order('fc.categoria');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'categoria' => 'text'
        );
    }
    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'fornecedores' => 'Fornecedores'
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