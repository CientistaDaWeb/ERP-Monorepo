<?php

class OrdemServicoImagens_Model extends WS_Model {

    public $_local;

    public function __construct() {
        $this->_db = new OrdemServicoImagens_Db();
        $this->_title = 'Gerenciador de Imagens de Ordens de Serviço';
        $this->_singular = 'Imagem de Ordem de Serviço';
        $this->_plural = 'Imagens de Ordens de Serviço';
        $this->_primary = 'osi.id';
        $this->_layoutList = 'basic';

        $this->_local = array(
            'V' => 'Visualização',
            'R' => 'Relatório',
        );

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('osi' => 'ordem_servico_imagens'), array('*'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = osi.ordem_servico_id', array(''));
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
            'ordem_servico_id' => array(
                'type' => 'Hidden'
            ),
            'legenda' => array(
                'type' => 'Text',
                'label' => 'Legenda',
                'required' => true
            ),
            'local' => array(
                'type' => 'Select',
                'label' => 'Localização',
                'options' => $this->_local,
                'required' => true,
            )
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'arquivo' => 'Arquivo',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'created' => 'datetime',
            'local' => 'getOption',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'osi.arquivo' => 'text',
        );
    }

    public function getByOS($ordem_servico_id, $local = NULL) {
        $sql = clone $this->_basicSearch;
        $sql->where('os.id = ?', $ordem_servico_id);
        if (!empty($local)):
            $sql->where('osi.local = ?', $local);
        endif;
        return $sql->query()->fetchAll();
    }

}

