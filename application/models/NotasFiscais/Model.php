<?php

class NotasFiscais_Model extends WS_Model {

    protected $_tipo;

    public function __construct() {

        $this->_db = new NotasFiscais_Db();
        $this->_title = 'Gerenciador de Notas Fiscais';
        $this->_singular = 'Nota Fiscal';
        $this->_plural = 'Notas Fiscais';
        $this->_layoutList = 'basic';
        $this->_primary = 'nf.id';

        $this->_tipo = array(
            'S' => 'Serviços',
            'P' => 'Projetos'
        );
        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('nf' => 'notas_fiscais'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = nf.orcamento_id', array(''))
                ->joinInner(array('e' => 'empresas'), 'e.id = nf.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'));
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'data_geracao' => 'desc',
            'numero' => 'asc'
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_geracao' => 'date',
            'valor' => 'money',
            'valor_retido' => 'money',
            'tipo' => 'getOption',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'nf.numero' => 'text',
            'nf.orcamento_id' => 'text',
            'nf.data_geracao' => 'date',
            'nf.valor' => 'money',
            'c.razao_social' => 'text',
            'e.razao_social' => 'text',
            'nf.tipo' => 'getOption',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'numero' => 'Nº NF',
            'orcamento_id' => 'Orçamento',
            'data_geracao' => 'Data de Emissão',
            'cliente' => 'Cliente',
            'empresa' => 'Empresa',
            'tipo' => 'Tipo',
            'valor' => 'Valor',
            'valor_retido' => 'Valor Retido',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'orcamento_id' => array(
                'type' => 'Hidden'
            ),
            'empresa_id' => array(
                'type' => 'Select',
                'label' => 'Empresa',
                'required' => true,
                'option' => array('' => 'Selecione a empresa ...'),
                'options' => Empresas_Model::fetchPair()
            ),
            'data_geracao' => array(
                'type' => 'Date',
                'label' => 'Data de Emissão',
                'required' => true
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
            'tipo' => array(
                'type' => 'Select',
                'label' => 'Tipo',
                'required' => true,
                'options' => $this->_tipo
            ),
        );
    }

    public function buscarPorOrcamento($orcamento_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('nf' => 'notas_fiscais'), array('*'))
                ->where('nf.orcamento_id = ?', $orcamento_id)
                ->order('nf.data_geracao DESC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarPorCliente($cliente_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('nf' => 'notas_fiscais'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = nf.orcamento_id', array(''))
                ->where('o.cliente_id = ?', $cliente_id)
                ->order('nf.data_geracao DESC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function getSumByPeriod($dataInicial, $dataFinal, $empresa_id = '') {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('nf' => 'notas_fiscais'), array('faturamento' => 'SUM(nf.valor)'))
                ->where('nf.data_geracao >= ?', $dataInicial)
                ->where('nf.data_geracao <= ?', $dataFinal);

        if(!empty($empresa_id)):
            $sql->where('nf.empresa_id = ?', $empresa_id);
        endif;
        return $sql->query()->fetch();
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('nf' => 'notas_fiscais'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = nf.orcamento_id', array('cliente_id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->order('nf.data_geracao ASC')
                ->order('nf.numero ASC');

        if (!empty($data['data_inicial'])):
            $consulta->where('nf.data_geracao >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('nf.data_geracao <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;
        if (!empty($data['cliente_id'])):
            $consulta->where('c.id = ?', $data['cliente_id']);
        endif;
        if (!empty($data['tipo'])):
            $consulta->where('nf.tipo = ?', $data['tipo']);
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

}
