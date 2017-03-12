<?php

class ProjetosArquitetonicos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ProjetosArquitetonicos_Db();
        $this->_title = 'Gerenciador de Projetos Arquitetônicos em Projetos';
        $this->_singular = 'Projeto Arquitetônico de Projeto';
        $this->_plural = 'Projetos Arquitetônicos de Projetos';
        $this->_primary = 'pa.id';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pa' => 'projetos_arquitetonicos'), array('*'))
                ->joinInner(array('p' => 'projetos'), 'p.id = pa.projeto_id', array(''));
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_recebimento' => 'date'
        );
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
            'data_recebimento' => array(
                'type' => 'Date',
                'label' => 'Data de Recebimento do Arquivo',
                'required' => true
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
            'data_recebimento' => 'Data',
            'descricao' => 'Descrição',
            'arquivo' => 'Arquivo',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'pa.data_recebimento' => 'date',
            'pa.descricao' => 'descricao',
        );
    }

    public function getByProject($projeto_id) {
        $sql = clone $this->_basicSearch;
        $sql->where('p.id = ?', $projeto_id)
                ->group('pa.id');
        return $sql->query()->fetchAll();
    }

    public function relatorio($projeto_id, $data) {
        $sql = clone($this->_basicSearch);
        $sql->where('p.id IN (?)', $projeto_id);
        $sql->joinInner(array('paa' => 'projetos_arquitetonicos_arquivos'), 'pa.id = paa.arquitetonico_id');
        if (!empty($data['data_inicial'])):
            $sql->where('pa.data_recebimento >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $sql->where('pa.data_recebimento <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        return $sql->query()->fetchAll();
    }

}

