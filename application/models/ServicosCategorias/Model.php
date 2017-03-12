<?php

class ServicosCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ServicosCategorias_Db();
        $this->_pair = 'categoria';
        $this->_title = 'Gerenciador de Categorias de Serviços';
        $this->_singular = 'Categoria de serviços';
        $this->_plural = 'Categorias de serviços';
        $this->_layoutList = 'basic';
        $this->_primary = 'sc.id';

        parent::__construct();
        parent::turningFemale();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('sc' => 'servicos_categorias'), array('id', 'categoria'));
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
            'servicos' => 'Serviços'
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
                ->from(array('sc' => 'servicos_categorias'), array('id', 'categoria'))
                ->joinLeft(array('s' => 'servicos'), 'sc.id = s.categoria_id', array('servicos' => 'COUNT(s.id)'))
                ->group('sc.id')
                ->order('categoria DESC');
    }

}