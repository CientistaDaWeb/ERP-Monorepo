<?php

class ModulosCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ModulosCategorias_Db();
        $this->_title = 'Gerenciador de Categorias de Módulos';
        $this->_singular = 'Categoria de Módulo';
        $this->_plural = 'Categorias de Módulo';
        $this->_primary = 'mc.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('mc' => 'modulos_categorias'), array('*'))
                ->joinLeft(array('m' => 'modulos'), 'mc.id = m.categoria_id', array('modulos' => 'COUNT(m.id)'))
                ->group('mc.id');
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('mc' => 'modulos_categorias'), array('id', 'categoria'))
                ->order('categoria');
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
            'ordem' => array(
                'type' => 'Number',
                'label' => 'Ordem',
                'required' => true
            )
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'ordem' => 'Ordem',
            'modulos' => 'Nº Módulos'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'mc.categoria' => 'text'
        );
    }

}

