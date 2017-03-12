<?php

class ProjetosCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ProjetosCategorias_Db();
        $this->_title = 'Gerenciador de Categorias de Projetos';
        $this->_singular = 'Categoria de Projeto';
        $this->_plural = 'Categorias de Projetos';
        $this->_primary = 'pc.id';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pc' => 'projetos_categorias'), array('*'))
                ->joinLeft(array('p' => 'projetos'), 'pc.id = p.categoria_id', array('projetos' => 'COUNT(p.id)'))
                ->group('pc.id');
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('pc' => 'projetos_categorias'), array('id', 'categoria'));
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
            )
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'projetos' => 'Nº Projetos'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'pc.categoria' => 'text'
        );
    }

}

