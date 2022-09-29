<?php

class Textos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Textos_Db();
        $this->_title = 'Gerenciador de Textos';
        $this->_singular = 'Texto';
        $this->_plural = 'Textos';
        $this->_layoutList = 'basic';
        $this->_primary = 't.id';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('t' => 'textos'), array('*'))
                ->joinInner(array('tc' => 'textos_categorias'), 'tc.id = t.categoria_id', array('categoria'))
                ;
    }

    public function getByCategoria($categoria_id) {
        $db = $this->getDefaultAdapter();
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from('textos', array('id', 'titulo'))
                ->where('categoria_id = ?', $categoria_id)
                ->order('titulo');
        $itens = $db->fetchPairs($consulta);
        return $itens;
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'categoria' => 'ASC'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'titulo' => 'Título'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            't.titulo' => 'text',
            'tc.categoria' => 'text'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'categoria_id' => array(
                'label' => 'Categoria',
                'type' => 'Select',
                'option' => array('' => 'Selecione a Categoria'),
                'options' => TextosCategorias_Model::fetchPair(),
                'required' => true
            ),
            'titulo' => array(
                'label' => 'Título',
                'type' => 'Text',
                'required' => true
            ),
            'descricao' => array(
                'label' => 'Descrição',
                'type' => 'Textarea',
                'required' => true
            )
        );
    }

}
