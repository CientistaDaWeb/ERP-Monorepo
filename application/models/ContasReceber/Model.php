<?php

class ContasReceber_Model extends WS_Model
{
    public function __construct()
    {
        $this->_db = new ContasReceber_Db();
        $this->_title = 'Gerenciador de Contas a Receber';
        $this->_singular = 'Conta a Receber';
        $this->_plural = 'Contas a Receber';
        $this->_layoutForm = false;
        $this->_layoutList = 'basic';
        $this->_primary = 'cr.id';


        parent::__construct();
        parent::turningFemale();

        $this->_buttons['pay'] = 'Pagar a ' . $this->_singular;
        $this->_buttons['print'] = 'Imprimir a ' . $this->_singular;
    }

    public function setBasicSearch()
    {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array('empresa_id'))
                ->joinInner(array('e' => 'empresas'), 'e.id = cr.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cr.forma_pagamento_id', array('forma_pagamento'))
                ->group('cr.id')
                ->order('cr.data_vencimento DESC');
    }

    public function setFormFields()
    {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'orcamento_id' => array(
                'type' => 'Hidden',
                'required' => true,
            ),
            'empresa_id' => array(
                'type' => 'Select',
                'label' => 'Empresa',
                'option' => array('' => 'Selecione a Empresa'),
                'options' => Empresas_Model::fetchPair(),
                'required' => true,
            ),
            'forma_pagamento_id' => array(
                'type' => 'Select',
                'label' => 'Forma de Pagamento',
                'option' => array('' => 'Selecione a Forma de Pagamento'),
                'options' => FormasPagamento_Model::fetchPair(),
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
            'valor_retido' => array(
                'type' => 'Money',
                'label' => 'Valor Retido',
            ),
            'data_lancamento' => array(
                'type' => 'Hidden',
                'required' => true,
                'label' => 'Data de Lançamento',
                'value' => date('d/m/Y')
            ),
            'descricao' => array(
                'type' => 'Text',
                'label' => 'Descrição'
            ),
            'endereco_id' => array(
                'type' => 'Select',
                'required' => true,
                'label' => 'Endereço',
                'options' => ClientesEnderecos_Model::fetchPair(),
            ),
            'observacoes' => array(
                'type' => 'Textarea',
                'label' => 'Observações',
                'class' => array('destaque')
            ),
        );
    }

    public function setFormFieldsPagar()
    {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden',
                'required' => true
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
            'valor_retido' => array(
                'type' => 'Money',
                'label' => 'Valor Retido',
            ),
        );
    }

    public function setOrderFields()
    {
        $this->_orderFields = array(
            'data_vencimento' => 'desc'
        );
    }

    public function setSearchFields()
    {
        $this->_searchFields = array(
            'cr.id' => 'text',
            'e.razao_social' => 'text',
            'c.razao_social' => 'text',
            'cr.data_vencimento' => 'date',
            'cr.data_pagamento' => 'date',
            'cr.valor' => 'money',
            'cr.valor_pago' => 'money',
            'cr.valor_retido' => 'money',
            'fp.forma_pagamento' => 'text',
        );
    }

    public function setAdjustFields()
    {
        $this->_adjustFields = array(
            'data_vencimento' => 'date',
            'valor' => 'money',
            'data_pagamento' => 'date',
            'data_lancamento' => 'date',
            'valor_pago' => 'money',
            'valor_retido' => 'money'
        );
    }

    public function setViewFields()
    {
        $this->_viewFields = array(
            'id' => 'Código',
            'cliente' => 'Cliente',
            'data_vencimento' => 'Vencimento',
            'valor' => 'Valor',
            'data_pagamento' => 'Pagamento',
            'valor_pago' => 'Valor Pago',
            'valor_retido' => 'Valor Retido',
            'empresa' => 'Empresa',
            'forma_pagamento' => 'Forma de Pagamento',
            'linkBoleto' => 'Boleto',
        );
    }

    public function adjustToView(array $data)
    {
        $WD = new WS_Date();
        $data['valor'] = $data['valor'] - $data['valor_retido'];
        $data = parent::adjustToView($data);

        $Vencimento = new WS_Date($data['data_vencimento']);
        if (!empty($data['valor_pago'])):
            $data['status'] = 'Pago';
        $data['class'] = 'pago'; elseif ($Vencimento->compare($WD->today()) == 1):
            $data['status'] = 'Em Aberto';
        $data['class'] = 'aberto'; else:
            $data['status'] = 'Atrasada';
        $data['class'] = 'atrasada';
        endif;
        $data['linkBoleto'] = '<a target="blank" href="/erp/Boleto-Itau/boleto/' . base64_encode($data['id']) . '">Imprimir</a>';
        return $data;
    }

    public function ajusteFluxo($data)
    {
        if (!empty($data)):
            foreach ($data as $item):
                $ret[$item['ano'] . '-' . substr('0' . $item['mes'], -2)]['contas_receber'] = $item['soma'];
        endforeach;
        return $ret;
        endif;
    }

    public function buscarPorPeriodo($dataInicial = '', $dataFinal = '', $empresa_id = '')
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from('contas_receber', array('ano' => 'YEAR(data_pagamento)', 'mes' => 'MONTH(data_pagamento)', 'soma' => 'SUM(valor_pago)', 'soma_retido' => 'SUM(valor_retido)'))
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
            if (is_array($empresa_id)):
                $consulta->where('empresa_id IN (?)', $empresa_id); else:
                $consulta->where('empresa_id = ?', $empresa_id);
        endif;
        endif;

        $consulta->where('data_pagamento >= ?', $dataInicial);
        $consulta->where('data_pagamento <= ?', $dataFinal);

        return $consulta->query()->fetchAll();
    }

    public function find($id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'cliente_id' => 'id'))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cr.forma_pagamento_id', array('forma_pagamento'))
                ->where('cr.id = ?', $id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function busca($busca = '', $page = 1)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('id', 'valor', 'data_vencimento', 'valor_pago', 'data_pagamento', 'orcamento_id', 'valor_retido'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array('empresa_id'))
                ->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->group('cr.id')
                ->order('cr.data_vencimento DESC')
        ;
        $paginator = parent::aplicaFiltros($consulta, $page, $busca);

        return $paginator;
    }

    public function buscarAcumulado($data_inicial, $empresa_id = '')
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('soma' => 'SUM(valor_pago)'))
                ->where('cr.data_pagamento < ?', $data_inicial);

        if (!empty($empresa_id)):
            $consulta->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array('empresa_id'));
        if (is_array($empresa_id)):
                $consulta->where('o.empresa_id IN (?)', $empresa_id); else:
                $consulta->where('o.empresa_id = ?', $empresa_id);
        endif;
        endif;

        $item = $consulta->query()->fetch();
        return $item;
    }

    public function contasAtrasadas()
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('data_vencimento', 'valor', 'id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array('orcamento_id' => 'id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
                ->where('cr.data_vencimento <= ?', date('Y-m-d'))
                ->where('cr.valor_pago IS NULL')
                ->order('cr.data_vencimento ASC');
        return $consulta->query()->fetchAll();
    }

    public function contasVencendo()
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('data_vencimento', 'valor', 'id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array('orcamento_id' => 'id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
                ->where('cr.data_vencimento < ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 15, date('Y'))))
                ->where('cr.data_vencimento > ?', date('Y-m-d'))
                ->where('cr.valor_pago IS NULL')
                ->order('cr.data_vencimento ASC');
        return $consulta->query()->fetchAll();
    }

    public function Relatorio($data)
    {
        $WD = new WS_Date();
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->joinInner(array('e' => 'empresas'), 'e.id = cr.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'cliente_id' => 'id'))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cr.forma_pagamento_id', array('forma_pagamento'));

        if (!empty($data['ordem'])):
            $consulta->order($data['ordem'] . ' ' . $data['ordem_tipo']); else:
            $consulta->order('cr.data_vencimento ASC');
        endif;

        if (!empty($data['data_inicial'])):
            $consulta->where('cr.data_vencimento >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;

        if (!empty($data['data_final'])):
            $consulta->where('cr.data_vencimento <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        if (!empty($data['data_inicial_pago'])):
            $consulta->where('cr.data_pagamento >= ?', WS_Date::adjustToDb($data['data_inicial_pago']));
        endif;

        if (!empty($data['data_final_pago'])):
            $consulta->where('cr.data_pagamento <= ?', WS_Date::adjustToDb($data['data_final_pago']));
        endif;

        if (!empty($data['data_inicial_lancamento'])):
            $consulta->where('cr.data_lancamento >= ?', WS_Date::adjustToDb($data['data_inicial_lancamento']));
        endif;

        if (!empty($data['data_final_lancamento'])):
            $consulta->where('cr.data_lancamento <= ?', WS_Date::adjustToDb($data['data_final_lancamento']));
        endif;

        if (!empty($data['status'])):
            if ($data['status'] == 'pagas'):
                $consulta->where('cr.valor_pago IS NOT NULL'); elseif ($data['status'] == 'vencidas'):
                $consulta->where('cr.valor_pago IS NULL');
        $consulta->where('cr.data_vencimento < ?', date('Y-m-d')); elseif ($data['status'] == 'aberto'):
                $consulta->where('cr.valor_pago IS NULL');
        $consulta->where('cr.data_vencimento >= ?', date('Y-m-d'));
        endif;
        endif;

        if (!empty($data['empresa_id'])):
            $consulta->where('cr.empresa_id = ?', $data['empresa_id']);
        endif;

        if (!empty($data['forma_pagamento_id'])):
            $consulta->where('cr.forma_pagamento_id = ?', $data['forma_pagamento_id']);
        endif;

        if (!empty($data['cliente_id'])):
            $consulta->where('c.id = ?', $data['cliente_id']);
        endif;

        $itens = $consulta->query()->fetchAll();

        return $itens;
    }

    public function buscarPorOrcamento($orcamento_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->where('o.id = ?', $orcamento_id)
                ->order('cr.data_vencimento ASC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function somaValores($orcamento_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*', 'soma' => '(SUM(cr.valor))'))
                ->where('cr.orcamento_id = ?', $orcamento_id);
        $itens = $consulta->query()->fetch();
        return $itens;
    }

    public function buscarDadosPorOrcamento($orcamento_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('total' => 'COUNT(cr.id)', 'soma' => 'SUM(cr.valor)', 'retido' => 'SUM(cr.valor_retido)'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->where('o.id = ?', $orcamento_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function buscarPorCliente($cliente_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('id', 'data_vencimento', 'valor', 'data_pagamento', 'valor_pago', 'orcamento_id', 'valor_retido', 'cte_id', 'cte_acqualife_id', 'cte_acquaservicos_id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joininner(array('c' => 'clientes'), 'c.id = o.cliente_id', array(''))
                ->where('c.id = ?', $cliente_id)
                ->order('cr.data_vencimento DESC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarSemRemessa($forma_pagamento_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('id', 'valor', 'data_vencimento', 'valor_retido'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->where('cr.forma_pagamento_id = ?', $forma_pagamento_id)
                ->where('cr.data_pagamento IS NULL')
                ->where('cr.remessa_id IS NULL')
                ->order('cr.data_vencimento ASC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarDadosCnab($conta_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('id', 'data_vencimento', 'valor', 'created', 'valor_retido'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array('cliente_id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social', 'documento_tipo', 'documento'))
                ->where('cr.id = ?', $conta_id);

        $item = $consulta->query()->fetch();
        return $item;
    }

    public function buscarPorRemessa($remessa_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('data_vencimento', 'valor', 'id', 'valor_retido'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->where('cr.remessa_id = ?', $remessa_id)
                ->order('cr.data_vencimento ASC');

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarPorRetorno($retorno_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('data_vencimento', 'valor', 'data_pagamento', 'valor_pago', 'orcamento_id', 'id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->where('cr.retorno_id = ?', $retorno_id)
                ->order('cr.data_vencimento ASC');

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarParaBoleto($boleto_id)
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('data_vencimento', 'valor', 'id', 'descricao', 'valor_retido'))
                ->joinInner(array('fp' => 'formas_pagamento'), 'fp.id = cr.forma_pagamento_id', array(''))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'cliente_documento' => 'documento', 'cliente_id' => 'id'))
                ->joinInner(array('e' => 'empresas'), 'e.id = cr.empresa_id', array('empresa' => 'razao_social', 'empresa_documento' => 'documento', 'empresa_endereco' => 'endereco', 'empresa_numero' => 'numero', 'empresa_bairro' => 'bairro', 'logomarca', 'empresa_cidade' => 'cidade', 'empresa_cep' => 'cep', 'empresa_telefone' => 'telefone'))
                ->joinInner(array('es' => 'estados'), 'es.id = e.estado_id', array('empresa_uf' => 'uf'))
                ->joinInner(array('b' => 'bancos'), 'e.id = b.empresa_id', array('conta_corrente', 'agencia', 'carteira'))
                ->joinLeft(array('ce' => 'clientes_enderecos'), 'ce.id = cr.endereco_id', array('cliente_endereco' => 'endereco', 'cliente_bairro' => 'bairro', 'cliente_numero' => 'numero', 'cliente_cep' => 'cep'))
                ->joinLeft(array('mu' => 'municipios'), 'mu.id = ce.municipio_id', array('cliente_cidade' => 'nome'))
                ->joinLeft(array('es2' => 'estados'), 'es.id = ce.estado_id', array('cliente_uf' => 'uf'))
                ->where('cr.id = ?', $boleto_id)
                ->where('fp.gera_remessa = ?', 'S')
                ->group('cr.id');

        $item = $consulta->query()->fetch();
        return $item;
    }

    public function getBillingByPeriod($dataInicial, $dataFinal)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('faturamento' => 'SUM(cr.valor)'))
                ->where('cr.data_lancamento >= ?', $dataInicial)
                ->where('cr.data_lancamento <= ?', $dataFinal);
        return $sql->query()->fetch();
    }

    public function getExtractBillingByPeriod($dataInicial, $dataFinal)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->where('cr.data_lancamento >= ?', $dataInicial)
                ->where('cr.data_lancamento <= ?', $dataFinal);
        return $sql->query()->fetchAll();
    }

    public function getRetainedByPeriod($dataInicial, $dataFinal, $empresa_id = '')
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('retido' => 'SUM(cr.valor_retido)'))
                ->where('cr.data_lancamento >= ?', $dataInicial)
                ->where('cr.data_lancamento <= ?', $dataFinal);

        if (!empty($empresa_id)):
            $sql->where('cr.empresa_id = ?', $empresa_id);
        endif;

        return $sql->query()->fetch();
    }

    public function buscaNaoProcessadasPorCliente($cliente_id)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array())
                ->where('o.cliente_id = ?', $cliente_id)
                ->where('cr.valor_pago IS NULL')
                ->where('cr.cte_id IS NULL')
                ->where('cr.cte_acqualife_id IS NULL');
        return $sql->query()->fetchAll();
    }

    public function buscaPorCte($cte_id)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->where('cr.cte_id = ? ', $cte_id);
        return $sql->query()->fetchAll();
    }

    public function buscaPorCteAcqualife($cte_id)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('*'))
                ->where('cr.cte_acqualife_id = ? ', $cte_id);
        return $sql->query()->fetchAll();
    }

  public function buscaPorCteAcquaservicos($cte_id)
  {
    $sql = $this->_db->select()
      ->setIntegrityCheck(false)
      ->from(array('cr' => 'contas_receber'), array('*'))
      ->where('cr.cte_acquaservicos_id = ? ', $cte_id);
    return $sql->query()->fetchAll();
  }

    public function buscaSomaPorCte($cte_id)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('total' => 'SUM(cr.valor)'))
                ->where('cr.cte_id = ? ', $cte_id)
                ->group('cr.cte_id');
        return $sql->query()->fetch();
    }

    public function buscaSomaPorCteAcqualife($cte_id)
    {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('total' => 'SUM(cr.valor)'))
                ->where('cr.cte_acqualife_id = ? ', $cte_id)
                ->group('cr.cte_acqualife_id');
        return $sql->query()->fetch();
    }

    public function buscarPorCategoria($dataInicial = '', $dataFinal = '', $categoria_id = '', $empresa_id = '')
    {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cr' => 'contas_receber'), array('total' => 'SUM(valor_pago)'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = cr.orcamento_id', array(''))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array(''))
                ->joinInner(array('cc' => 'clientes_categorias'), 'cc.id = c.categoria_id', array('categoria'))
                ->group('c.categoria_id')
                ->order('categoria')
        ;

        if (!empty($empresa_id)):
            if (is_array($empresa_id)):
                $consulta->where('o.empresa_id IN (?)', $empresa_id); else:
                $consulta->where('o.empresa_id = ?', $empresa_id);
        endif;
        endif;

        if (!isset($dataInicial) && !isset($dataFinal)):
            $data = new Zend_Date(date('Y') . '-' . date('m') . '-01');
        $dataFinal = $data->addMonth(6)->toString('yyyy-MM-dd');
        $dataInicial = $data->subMonth(12)->toString('yyyy-MM-dd');
        endif;

        $consulta->where('cr.data_pagamento >= ?', $dataInicial);
        $consulta->where('cr.data_pagamento <= ?', $dataFinal);



        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscaPorClienteParaCte($cliente_id)
    {
        $sql = clone ($this->_basicSearch);
        $sql->where('o.cliente_id = ?', $cliente_id)
            ->where('cr.cte_id IS NULL')
            ->where('cr.cte_acqualife_id IS NULL');

        return $sql->query()->fetchAll();
    }
}
