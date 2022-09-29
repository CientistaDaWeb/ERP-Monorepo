<?php

class EmpresasArquivosCategorias_Model extends WS_Model {

    public function __construct() {
        $this->_db = new EmpresasArquivosCategorias_Db();
        $this->_title = 'Gerenciador de Categorias de Arquivos de Empresas';
        $this->_singular = 'Categoria de Arquivos de Empresa';
        $this->_plural = 'Categorias de Arquivos de Empresa';
        $this->_primary = 'cac.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cac' => 'empresas_arquivos_categorias'), array('*'))
                ->joinLeft(array('ca' => 'empresas_arquivos'), 'cac.id = ca.categoria_id', array('arquivos' => 'COUNT(ca.id)'))
                ->group('cac.id');
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('cac' => 'empresas_arquivos_categorias'), array('id', 'categoria'));
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
            'arquivos' => 'Nº Arquivos'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'cac.categoria' => 'text'
        );
    }

}

