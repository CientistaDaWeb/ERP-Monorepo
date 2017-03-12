<?php

class ProjetosArquitetonicosArquivos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ProjetosArquitetonicosArquivos_Db();
        $this->_title = 'Gerenciador de Arquivos Projetos Arquitetônicos em Projetos';
        $this->_singular = 'Arquivo de Projeto Arquitetônico';
        $this->_plural = 'Arquivos de Projeto Arquitetônicos';
        $this->_primary = 'paa.id';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('paa' => 'projetos_arquitetonicos_arquivos'), array('*'))
                ->joinInner(array('pa' => 'projetos_arquitetonicos'), 'pa.id = paa.arquitetonico_id', array(''));
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
            'arquivo' => array(
                'type' => 'Hidden',
            ),
            'arquitetonico_id' => array(
                'type' => 'Hidden'
            ),
            'upload' => array(
                'type' => 'File',
                'label' => 'Arquivo',
                'ignore' => true,
                'extension' => array('dwg', 'dxf', 'prh', 'doc', 'docx', 'xls', 'xlsx'),
                'size' => array('max' => '60728640', 'min' => '0'),
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

    public function setAdjustFields(){
        $this->_adjustFields = array(
            'created' => 'datetime'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'paa.arquivo' => 'date',
        );
    }

    public function getByProject($projeto_id) {
        $sql = clone $this->_basicSearch;
        $sql->where('pa.id = ?', $projeto_id)
                ->group('paa.id');
        return $sql->query()->fetchAll();
    }

}

