<?php

class TemplatesCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new TemplatesCategorias_Db();
        $this->_pair = 'categoria';
        $this->_title = 'Gerenciador de Categorias de Templates';
        $this->_singular = 'Categoria de Templates';
        $this->_plural = 'Categorias de Templates';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'tc.id';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('tc' => 'templates_categorias'), array('id', 'categoria'));
        return $db->fetchPairs($sql);
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'categoria' => 'text'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'templates' => 'Templates'
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

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pc' => 'projetos_categorias'), array('id', 'categoria'))
                ->joinLeft(array('t' => 'templates'), 'pc.id = t.categoria_id', array('templates' => 'COUNT(t.id)'))
                ->group('tc.id')
                ->order('categoria DESC');
    }

}