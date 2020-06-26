<?php

class ContasPagar_Model extends WS_Model {

    protected $_conta_fixa;

    public function __construct() {
        $this->_db = new ContasPagar_Db();
        $this->_title = 'Gerenciador de Contas a Pagar';
        $this->_singular = 'Conta a Pagar';
        $this->_plural = 'Contas a Pagar';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'cp.id';

        $this->_conta_fixa = array(
            '1' => 'Fixa',
            '2' => 'Variável',
        );

        parent::__construct();
        parent::turningFemale();

        $this->_buttons['pay'] = 'Pagar a ' . $this->_singular;
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('*'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = cp.fornecedor_id', array('fornecedor' => 'razao_social'))
                ->joinInner(array('e' => 'empresas'), 'e.id = cp.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('cpc' => 'contas_pagar_categorias'), 'cpc.id = cp.categoria_id', array('categoria'))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cp.forma_pagamento_id', array('forma_pagamento'))
                ->group('cp.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'cp.data_vencimento' => 'date',
            'cp.data_pagamento' => 'date',
            'cp.valor' => 'money',
            'cp.valor_pago' => 'money',
            'e.razao_social' => 'text',
            'f.razao_social' => 'text',
            'cpc.categoria' => 'text',
            'fp.forma_pagamento' => 'text',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden',
            ),
            'empresa_id' => array(
                'type' => 'Select',
                'label' => 'Empresa',
                'option' => array('' => 'Selecione a Empresa'),
                'options' => Empresas_Model::fetchPair(),
                'required' => true,
            ),
            'conta_fixa' => array(
                'type' => 'Select',
                'label' => 'Conta Fixa',
                'option' => array('' => 'Selecione'),
                'options' => $this->_conta_fixa,
                'required' => true
            ),
            'forma_pagamento_id' => array(
                'type' => 'Select',
                'label' => 'Forma de Pagamento',
                'option' => array('' => 'Selecione a Forma de Pagamento'),
                'options' => FormasPagamento_Model::fetchPair(),
                'required' => true,
            ),
            'categoria_id' => array(
                'type' => 'Select',
                'label' => 'Categoria',
                'option' => array('' => 'Selecione a Categoria'),
                'options' => ContasPagarCategorias_Model::fetchPair(),
                'required' => true,
            ),
            'fornecedor_id' => array(
                'type' => 'Select',
                'label' => 'Fornecedor',
                'option' => array('' => 'Selecione o Fornecedor'),
                'options' => Fornecedores_Model::fetchPair(),
                'required' => true,
            ),
            'data_vencimento' => array(
                'type' => 'Date',
                'required' => true,
                'label' => 'Data de Vencimento'
            ),
            'valor' => array(
                'type' => 'Money',
                'label' => 'Valor',
                'required' => true,
            ),
            'valor_pago' => array(
                'type' => 'Money',
                'label' => 'Valor Pago',
                'required' => true,
            ),
            'data_pagamento' => array(
                'type' => 'Date',
                'required' => true,
                'label' => 'Data de Pagamento',
            ),
            'data_lancamento' => array(
                'type' => 'Date',
                'required' => true,
                'label' => 'Data de Lançamento',
                'value' => date('d/m/Y')
            ),
            'observacoes' => array(
                'type' => 'Textarea',
                'label' => 'Observações'
            ),
        );
    }

    public function setFormFieldsPagar() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden',
                'required' => true,
            ),
            'forma_pagamento_id' => array(
                'type' => 'Select',
                'label' => 'Forma de Pagamento',
                'option' => array('' => 'Selecione a Forma de Pagamento'),
                'options' => FormasPagamento_Model::fetchPair(),
                'required' => true,
            ),
            'data_pagamento' => array(
                'type' => 'Date',
                'required' => true,
                'label' => 'Data de Pagamento'
            ),
            'valor_pago' => array(
                'type' => 'Money',
                'label' => 'Valor Pago',
                'required' => true,
            ),
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_pagamento' => 'date',
            'data_vencimento' => 'date',
            'data_lancamento' => 'date',
            'valor' => 'money',
            'valor_pago' => 'money'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data_vencimento' => 'Data de Vencimento',
            'fornecedor' => 'Fornecedor',
            'categoria' => 'Categoria',
            'valor' => 'Valor',
            'data_pagamento' => 'Data de Pagamento',
            'valor_pago' => 'Valor Pago',
            'empresa' => 'Empresa',
            'forma_pagamento' => 'Forma de Pagamento',
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'cp.data_vencimento' => 'desc'
        );
    }

    public function adjustToView(array $data) {
        $WD = new WS_Date();
        $data = parent::adjustToView($data);

        $Vencimento = new WS_Date($data['data_vencimento']);
        if (!empty($data['valor_pago'])):
            $data['status'] = 'Pago';
            $data['class'] = 'pago';
        elseif ($Vencimento->compare($WD->today()) == 1):
            $data['status'] = 'Em Aberto';
            $data['class'] = 'aberto';
        else:
            $data['status'] = 'Atrasada';
            $data['class'] = 'atrasada';
        endif;
        return $data;
    }

    public function ajusteFluxo($data) {
        if (!empty($data)):
            foreach ($data AS $item):
                $ret[$item['ano'] . '-' . substr('0' . $item['mes'], -2)]['contas_pagar'] = $item['soma'];
            endforeach;
            return $ret;
        endif;
    }

    public function buscarPorPeriodo($dataInicial = '', $dataFinal = '', $empresa_id = '') {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from('contas_pagar', array('ano' => 'YEAR(data_pagamento)', 'mes' => 'MONTH(data_pagamento)', 'soma' => 'SUM(valor_pago)'))
                ->group('YEAR(data_pagamento)')
                ->group('MONTH(data_pagamento)')
                ->order('YEAR(data_pagamento)')
                ->order('MONTH(data_pagamento)');

        if (!isset($dataInicial) && !isset($dataFinal)):
            $data = new Zend_Date(date('Y') . '-' . date('m') . '-01');
            $dataFinal = $data->addMonth(6)->toString('yyyy-MM-dd');
            $dataInicial = $data->subMonth(12)->toString('yyyy-MM-dd');
        endif;

        if (!empty($empresa_id)):
            if(is_array($empresa_id)):
                $consulta->where('empresa_id IN (?)', $empresa_id);
            else:
                $consulta->where('empresa_id = ?', $empresa_id);
            endif;
        endif;

        $consulta->where('data_pagamento >= ?', $dataInicial);
        $consulta->where('data_pagamento <= ?', $dataFinal);

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function adjustToForm(array $data) {
        if (empty($data['data_lancamento'])):
            $data['data_lancamento'] = date('d/m/Y');
        endif;
        return parent::adjustToForm($data);
    }

    public function buscarPorCategoria($dataInicial = '', $dataFinal = '', $empresa_id = '') {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('total' => 'SUM(valor_pago)'))
                ->joinInner(array('e' => 'empresas'), 'e.id = cp.empresa_id', array(''))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = cp.fornecedor_id', array(''))
                ->joinInner(array('fc' => 'fornecedores_categorias'), 'fc.id = f.categoria_id', array(''))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cp.forma_pagamento_id', array(''))
                ->joinInner(array('cpc' => 'contas_pagar_categorias'), 'cpc.id = cp.categoria_id', array('categoria'))
                ->group('cp.categoria_id');

        if (!isset($dataInicial) && !isset($dataFinal)):
            $data = new Zend_Date(date('Y') . '-' . date('m') . '-01');
            $dataFinal = $data->addMonth(6)->toString('yyyy-MM-dd');
            $dataInicial = $data->subMonth(12)->toString('yyyy-MM-dd');
        endif;

        if (!empty($empresa_id)):
            if(is_array($empresa_id)):
                $consulta->where('e.id IN (?)', $empresa_id);
            else:
                $consulta->where('e.id = ?', $empresa_id);
            endif;
        endif;


        $consulta->where('data_pagamento >= ?', $dataInicial);
        $consulta->where('data_pagamento <= ?', $dataFinal);

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarAcumulado($data_inicial, $empresa_id = '') {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('soma' => 'SUM(valor_pago)'))
                ->where('cp.data_pagamento < ?', $data_inicial);

        if (!empty($empresa_id)):
            $consulta->joinInner(array('e' => 'empresas'), 'e.id = cp.empresa_id', array(''));
            if(is_array($empresa_id)):
                $consulta->where('e.id IN (?)', $empresa_id);
            else:
                $consulta->where('e.id = ?', $empresa_id);
            endif;
        endif;

        $item = $consulta->query()->fetch();
        return $item;
    }

    public function contasAtrasadas() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('data_vencimento', 'valor', 'id'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = cp.fornecedor_id', array('razao_social'))
                ->where('cp.data_vencimento <= ?', date('Y-m-d'))
                ->where('cp.valor_pago IS NULL')
                ->order('cp.data_vencimento ASC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function contasVencendo() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('data_vencimento', 'valor', 'id'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = cp.fornecedor_id', array('razao_social'))
                ->where('cp.data_vencimento <= ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 15, date('Y'))))
                ->where('cp.data_vencimento >= ?', date('Y-m-d'))
                ->where('cp.valor_pago IS NULL')
                ->order('cp.data_vencimento ASC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function Relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('data_vencimento', 'data_pagamento', 'conta_fixa', 'id', 'valor', 'valor_pago', 'data_lancamento'))
                ->joinInner(array('e' => 'empresas'), 'e.id = cp.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = cp.fornecedor_id', array('fornecedor' => 'razao_social', 'fornecedor_id' => 'id'))
                ->joinInner(array('fc' => 'fornecedores_categorias'), 'fc.id = f.categoria_id', array('categoria_fornecedor' => 'categoria'))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cp.forma_pagamento_id', array('forma_pagamento'))
                ->joinInner(array('cpc' => 'contas_pagar_categorias'), 'cpc.id = cp.categoria_id', array('categoria'))
                ->group('cp.id');

        if (!empty($data['ordem'])):
            $consulta->order($data['ordem'] . ' ' . $data['ordem_tipo']);
        else:
            $consulta->order('cp.data_vencimento ASC');
        endif;

        if (!empty($data['data_inicial'])):
            $consulta->where('cp.data_vencimento >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;

        if (!empty($data['data_final'])):
            $consulta->where('cp.data_vencimento <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        if (!empty($data['forma_pagamento_id'])):
            $consulta->where('fp.id = ?', $data['forma_pagamento_id']);
        endif;

        if (!empty($data['data_inicial_pago'])):
            $consulta->where('cp.data_pagamento >= ?', WS_Date::adjustToDb($data['data_inicial_pago']));
        endif;

        if (!empty($data['data_final_pago'])):
            $consulta->where('cp.data_pagamento <= ?', WS_Date::adjustToDb($data['data_final_pago']));
        endif;

        if (!empty($data['data_inicial_lancamento'])):
            $consulta->where('cp.data_lancamento >= ?', WS_Date::adjustToDb($data['data_inicial_lancamento']));
        endif;

        if (!empty($data['data_final_lancamento'])):
            $consulta->where('cp.data_lancamento <= ?', WS_Date::adjustToDb($data['data_final_lancamento']));
        endif;

        if (!empty($data['empresa_id'])):
            $consulta->where('e.id = ?', $data['empresa_id']);
        endif;

        if (!empty($data['fornecedor_id'])):
            $consulta->where('f.id = ?', $data['fornecedor_id']);
        endif;

        if (!empty($data['fornecedor_categoria_id'])):
            $consulta->where('fc.id = ?', $data['fornecedor_categoria_id']);
        endif;

        if (!empty($data['categoria_id'])):
            $consulta->where('cpc.id = ?', $data['categoria_id']);
        endif;

        if (!empty($data['conta_fixa'])):
            $consulta->where('cp.conta_fixa = ?', $data['conta_fixa']);
        endif;

        if (!empty($data['forma_pagamento_id'])):
            $consulta->where('cp.forma_pagamento_id = ?', $data['forma_pagamento_id']);
        endif;

        if (!empty($data['status'])):
            if ($data['status'] == 'pagas'):
                $consulta->where('cp.valor_pago IS NOT NULL');
            elseif ($data['status'] == 'vencidas'):
                $consulta->where('cp.valor_pago IS NULL');
                $consulta->where('cp.data_vencimento < NOW()');
            elseif ($data['status'] == 'aberto'):
                $consulta->where('cp.valor_pago IS NULL');
                $consulta->where('cp.data_vencimento >= NOW()');
            endif;
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function getSumByPeriod($dataInicial, $dataFinal, $conta_fixa, $ignore = NULL, $empresa_id = '') {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('custo' => 'SUM(cp.valor)'))
                ->where('cp.data_lancamento >= ?', $dataInicial)
                ->where('cp.data_lancamento <= ?', $dataFinal)
                ->where('cp.conta_fixa = ?', $conta_fixa);
        if ($ignore):
            $sql->where('cp.categoria_id != ?', '8');
        endif;
        if (!empty($empresa_id)):
            $sql->where('cp.empresa_id = ?', $empresa_id);
        endif;
        return $sql->query()->fetch();
    }

    public function getSumByPeriodCategory($dataInicial, $dataFinal, $ignore = NULL, $empresa_id = '') {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cp' => 'contas_pagar'), array('total' => 'SUM(cp.valor)'))
                ->joinInner(array('cpc' => 'contas_pagar_categorias'), 'cpc.id = cp.categoria_id', array('categoria'))
                ->where('cp.data_lancamento >= ?', $dataInicial)
                ->where('cp.data_lancamento <= ?', $dataFinal)
                ->group('cpc.id')
                ->order('cpc.categoria');

        if ($ignore):
            $sql->where('cpc.id != ?', '8');
        endif;

        if (!empty($empresa_id)):
            $sql->where('cp.empresa_id = ?', $empresa_id);
        endif;

        return $sql->query()->fetchAll();
    }

}
