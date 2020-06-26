<?php

class Templates_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Templates_Db();
        $this->_title = 'Gerenciador de Modelos de Atividades de Categorias de Projetos';
        $this->_singular = 'Modelo de Atividade de Categoria de Projeto';
        $this->_plural = 'Modelos de Atividades de Categorias de Projetos';
        $this->_primary = 't.id';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('t' => 'templates'), array('*'))
                ->joinInner(array('pc' => 'projetos_categorias'), 'pc.id = t.categoria_id', array());
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('t' => 'templates'), array('id', 'nome'));
        return $db->fetchPairs($sql);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'categoria_id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Nome',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'Textarea',
                'label' => 'Descrição',
                'required' => true
            ),
            'pontos' => array(
                'type' => 'Number',
                'label' => 'Pontos',
                'required' => true
            ),
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

    public function getByCategory($categoria_id) {
        $sql = clone $this->_basicSearch;
        $sql->where('pc.id = ?', $categoria_id)
                ->group('t.id');
        return $sql->query()->fetchAll();
    }

    public function findByDescription($descricao) {
        $sql = clone($this->_basicSearch);
        $sql->where('t.descricao = ?', $descricao)
                ->limit(1);
        return $sql->query()->fetch();
    }

}

