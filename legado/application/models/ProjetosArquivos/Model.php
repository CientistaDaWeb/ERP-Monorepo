<?php

class ProjetosArquivos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ProjetosArquivos_Db();
        $this->_title = 'Gerenciador de Arquivos em Projetos';
        $this->_singular = 'Arquivo de Projeto';
        $this->_plural = 'Arquivos de Projeto';
        $this->_primary = 'pa.id';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pa' => 'projetos_arquivos'), array('*'))
                ->joinInner(array('p' => 'projetos'), 'p.id = pa.projeto_id', array(''));
    }

    public function adjustToDb(array $data) {
        if (empty($data['arquivo'])):
            unset($data['arquivo']);
        endif;
        return parent::adjustToDb($data);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'projeto_id' => array(
                'type' => 'Hidden'
            ),
            'categoria_id' => array(
                'label' => 'Categoria',
                'type' => 'Select',
                'option' => array(' ' => 'Selecione...'),
                'options' => ProjetosCategorias_Model::fetchPair()
            ),
            'descricao' => array(
                'type' => 'Textarea',
                'label' => 'Descrição',
                'required' => true
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'arquivo' => 'Arquivo',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'created' => 'datetime'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'pa.arquivo' => 'text',
        );
    }

    public function getByProject($projeto_id) {
        $sql = clone $this->_basicSearch;
        $sql->joinInner(array('pc' => 'projetos_categorias'), 'pc.id = pa.categoria_id', array('categoria'))
                ->where('p.id = ?', $projeto_id)
                ->group('pa.id');
        return $sql->query()->fetchAll();
    }

}
