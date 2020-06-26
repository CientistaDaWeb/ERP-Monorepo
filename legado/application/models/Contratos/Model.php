<?php

class Contratos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Contratos_Db();
        $this->_title = 'Gerenciador de Contratos';
        $this->_singular = 'Contrato';
        $this->_plural = 'Contratos';
        $this->_primary = 'c.id';
        $this->_layoutList = 'basic';

        parent::__construct();

        $this->_servico_contratado = array(
            '1' => 'Transporte',
            '2' => 'Tratamento',
            '3' => 'Transporte e Tratamento'
        );
        $this->_tipo_efluente = array(
            '' => 'Nenhum',
            '1' => 'Industrial',
            '2' => 'Fossa Séptica',
            '3' => 'Fossa Séptica e Gordura'
        );
        $this->_acabado = array(
            'N' => 'Não',
            'S' => 'Sim'
        );
    }

    public function adjustToView(array $data) {
        $WD = new WS_Date();
        $Vencimento = new WS_Date($data['data_encerramento']);
        if ($Vencimento->compare($WD->today()) == -1):
            $data['class'] = 'atrasada';
        endif;
        return parent::adjustToView($data);
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_assinatura' => 'date',
            'data_encerramento' => 'date',
            'servico_contratado' => 'getOption',
            'tipo_efluente' => 'getOption',
            'valor_transporte' => 'money',
            'valor_tratamento' => 'money',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'orcamento_id' => 'Orçamento',
            'cliente' => 'Cliente',
            'data_assinatura' => 'Data de Assinatura',
            'data_encerramento' => 'Data de Encerramento',
            'empresa' => 'Empresa',
            'servico_contratado' => 'Serviço Contratado',
            'valor_transporte' => 'Valor Trans.',
            'valor_tratamento' => 'Valor Trat. (m³)',
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'data_encerramento' => 'asc',
            'data_assinatura' => 'asc'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'c.data_assinatura' => 'date',
            'c.data_encerramento' => 'date',
            'cl.valor' => 'money',
            'cl.razao_social' => 'text',
            'e.razao_social' => 'text',
            'e.servico_contratado' => 'getOption',
        );
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'contratos'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = c.orcamento_id', array(''))
                ->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'));
    }

    public function buscarPorOrcamento($orcamento_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'contratos'), array('*'))
                ->where('c.orcamento_id = ?', $orcamento_id);
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarPorCliente($cliente_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'contratos'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = c.orcamento_id', array(''))
                ->where('o.cliente_id = ?', $cliente_id);
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function contratosEncerrando() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'contratos'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = c.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->where('c.data_encerramento <= ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 15, date('Y'))))
                ->where('c.acabado = ?', 'N');

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('co' => 'contratos'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = co.orcamento_id', array('cliente_id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->order('co.data_assinatura ASC');

        if (!empty($data['assinatura_data_inicial'])):
            $consulta->where('co.data_assinatura >= ?', WS_Date::adjustToDb($data['assinatura_data_inicial']));
        endif;
        if (!empty($data['assinatura_data_final'])):
            $consulta->where('co.data_assinatura <= ?', WS_Date::adjustToDb($data['assinatura_data_final']));
        endif;
        if (!empty($data['encerramento_data_inicial'])):
            $consulta->where('co.data_encerramento >= ?', WS_Date::adjustToDb($data['encerramento_data_inicial']));
        endif;
        if (!empty($data['assinatura_data_final'])):
            $consulta->where('co.data_encerramento <= ?', WS_Date::adjustToDb($data['encerramento_data_final']));
        endif;
        if (!empty($data['cliente_id'])):
            $consulta->where('c.id = ?', $data['cliente_id']);
        endif;
        if (!empty($data['servico_contratado'])):
            $consulta->where('co.servico_contratado = ?', $data['servico_contratado']);
        endif;
        if (!empty($data['tipo_efluente'])):
            $consulta->where('co.tipo_efluente = ?', $data['tipo_efluente']);
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

}
