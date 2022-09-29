<?php

class NotasProjetos_Model extends WS_Model {

    public function __construct() {

        $this->_db = new NotasProjetos_Db();
        $this->_title = 'Gerenciador de Notas Fiscais de Projetos';
        $this->_singular = 'Nota Fiscal de Projetos';
        $this->_plural = 'Notas Fiscais de Projetos';
        $this->_layoutList = 'basic';
        $this->_primary = 'np.id';

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('np' => 'notas_projetos'), array('*'))
                ;
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'data_emissao' => 'desc'
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_emissao' => 'date',
            'valor' => 'money',
            'valor_retido' => 'money',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'np.numero' => 'text',
            'np.cliente' => 'text',
            'np.data_emissao' => 'date',
            'np.valor' => 'money',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'numero' => 'Nº NF',
            'data_emissao' => 'Data de Emissão',
            'cliente' => 'Cliente',
            'valor' => 'Valor',
            'valor_retido' => 'Valor Retido',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'data_emissao' => array(
                'type' => 'Date',
                'label' => 'Data de Emissão',
                'required' => true
            ),
            'cliente' => array(
                'type' => 'Text',
                'label' => 'Cliente',
                'required' => true,
            ),
            'numero' => array(
                'type' => 'Text',
                'label' => 'Número da Nota Fiscal',
                'required' => true
            ),
            'valor' => array(
                'type' => 'Money',
                'label' => 'Valor',
                'required' => true
            ),
            'valor_retido' => array(
                'type' => 'Money',
                'label' => 'Valor Retido'
            ),
        );
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('np' => 'notas_projetos'), array('*'))
                ->order('np.data_emissao ASC');

        if (!empty($data['data_inicial'])):
            $consulta->where('np.data_emissao >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('np.data_emissao <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

}
