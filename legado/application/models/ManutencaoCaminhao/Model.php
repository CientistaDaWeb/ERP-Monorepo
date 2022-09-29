<?php

class ManutencaoCaminhao_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ManutencaoCaminhao_Db();
        $this->_title = 'Gerenciador de Manutenções de Caminhão';
        $this->_singular = 'Manutenção de Caminhão';
        $this->_plural = 'Manutenções de Caminhão';
        $this->_primary = 'm.id';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'manutencoes'), array('*'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = m.fornecedor_id', array('fornecedor' => 'razao_social'))
                ->group('m.id')
                ->order('m.data DESC');
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'm.data' => 'date',
            'f.fornecedor' => 'text',
            'm.observacoes' => 'text',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data' => 'Data',
            'fornecedor' => 'Fornecedor',
            'valor' => 'Valor'
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'data' => 'desc',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'fornecedor_id' => array(
                'type' => 'Select',
                'label' => 'Fornecedor',
                'options' => Fornecedores_Model::fetchPair(),
                'required' => true
            ),
            'data' => array(
                'type' => 'Date',
                'label' => 'Data',
                'required' => true
            ),
            'valor' => array(
                'type' => 'Money',
                'label' => 'Valor',
                'required' => true
            ),
            'observacoes' => array(
                'label' => 'Observações',
                'type' => 'Textarea',
            ),
        );
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'manutencoes'), array('*'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = m.fornecedor_id', array('razao_social'))
                ->order('m.data ASC')
        ;

        if (!empty($data['data_inicial'])):
            $consulta->where('m.data >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('m.data <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;
        if (!empty($data['fornecedor_id'])):
            $consulta->where('f.id = ?', $data['fornecedor_id']);
        endif;
        if (!empty($data['peca_id'])):
            $consulta->where('p.id = ?', $data['peca_id']);
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscaTotal($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'manutencoes'), array('total' => 'SUM(m.valor)'))
        ;
        if (!empty($data['data_inicial'])):
            $consulta->where('m.data >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('m.data <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        $itens = $consulta->query()->fetch();
        return $itens;
    }

}
