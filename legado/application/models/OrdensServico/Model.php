<?php

class OrdensServico_Model extends WS_Model
{

	protected $_status, $_tipo_reservatorio, $_acesso, $_situacao_efluentes, $checagem_final;

	public function __construct()
	{
		$this->_db = new OrdensServico_Db();
		$this->_title = 'Gerenciador de Ordens de Serviço';
		$this->_singular = 'Ordem de Serviço';
		$this->_plural = 'Ordens de Serviço';
		$this->_primary = 'os.id';
		$this->_layoutList = 'basic';
		$this->_layoutForm = false;

		$this->_status = array(
			1 => 'Aguardando',
			2 => 'Executando',
			3 => 'Concluido',
			4 => 'Cancelada',
			5 => 'Cortesia',
      6 => 'Faturado para terceiros'
		);
		$this->_tipo_reservatorio = array(
			'F' => 'FOSSA',
			'I' => 'FILTRO',
			'FF' => 'FOSSA/FILTRO',
			'T' => 'TANQUE',
			'B' => 'BOMBONA',
			'O' => 'OUTROS'
		);
		$this->_acesso = array(
			'D' => 'DIFÍCIL',
			'R' => 'REGULAR',
			'F' => 'FÁCIL'
		);
		$this->_situacao_efluentes = array(
			'N' => 'RESÍDUO NORMAL',
			'M' => 'RESÍDUO COM MISTURAS',
			'A' => 'RESÍDUO ALTERADO'
		);
		$this->_checagem_final = array(
			'L' => 'LACRE DA FOSSA',
			'LL' => 'LIMPEZA DO LOCAL',
			'M' => 'MTR',
			'F' => 'FICHA DE EMERGÊNCIA',
			'E' => "EPI's",
			'P' => 'PLACAS',
		);
		$this->_faturado = array(
			'N' => 'Não',
			'S' => 'Sim',
		);

		parent::__construct();
		parent::turningFemale();
	}

	public function setBasicSearch()
	{
		$this->_basicSearch = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('*', 'saldo' => '(os.valor - os.desconto)'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'cliente_id' => 'id'))
			->group('os.id')
			->order('os.data_coleta DESC');
	}

	public function adjustToDb(array $data)
	{
		if (empty($data['valor'])):
			$data['valor'] = 0;
		endif;
		if (empty($data['desconto'])):
			$data['desconto'] = 0;
		endif;
		return parent::adjustToDb($data);
	}

	public function setAdjustFields()
	{
		$this->_adjustFields = array(
			'data_coleta' => 'date',
			'status' => 'getOption',
			'valor' => 'money',
			'desconto' => 'money',
			'saldo' => 'money',
			'tipo_reservatorio' => 'getOption',
			'acesso' => 'getOption',
			'situacao_efluentes' => 'getOption',
			'faturado' => 'getOption',
		);
	}

	public function setSearchFields()
	{
		$this->_searchFields = array(
			'os.data_coleta' => 'date',
			'os.orcamento_id' => 'text',
			'c.razao_social' => 'text',
			'os.valor' => 'money'
		);
	}

	public function setViewFields()
	{
		$this->_viewFields = array(
			'codigo' => 'Código',
			'data_coleta' => 'Data',
			'cliente' => 'Cliente',
			'saldo' => 'Valor'
		);
	}

	public function setOrderFields()
	{
		$this->_orderFields = array(
			'data_coleta' => 'desc',
			'status' => 'asc',
		);
	}

	public function setFormFields()
	{
		$this->_formFields = array(
			'id' => array(
				'type' => 'Hidden'
			),
			'sequencial' => array(
				'type' => 'Hidden'
			),
			'orcamento_id' => array(
				'type' => 'Hidden',
				'required' => true
			),
			'endereco_id' => array(
				'type' => 'Select',
				'required' => true,
				'label' => 'Endereço',
				'options' => ClientesEnderecos_Model::fetchPair(),
			),
			'empresa_id' => array(
				'type' => 'Select',
				'label' => 'Empresa',
				'options' => Empresas_Model::fetchPair(),
				'required' => true
			),
			'transportador_id' => array(
				'type' => 'Select',
				'label' => 'Transportador',
				'options' => Transportadores_Model::fetchPair(),
				'required' => true
			),
			'data_coleta' => array(
				'type' => 'Date',
				'label' => 'Data de Coleta',
				'required' => true
			),
			'hora_coleta' => array(
				'type' => 'Hour',
				'label' => 'Hora da Coleta',
				'required' => true
			),
			'valor' => array(
				'type' => 'Money',
				'label' => 'Valor'
			),
			'desconto' => array(
				'type' => 'Money',
				'label' => 'Desconto'
			),
			'numero_coletas' => array(
				'type' => 'Select',
				'label' => 'Nº Coletas Programadas',
				'required' => true,
				'options' => array(1 => 1, 2, 3, 4, 5, 6)
			),
			'status' => array(
				'type' => 'Select',
				'label' => 'Status',
				'options' => $this->listOptions('status'),
				'required' => true
			),
			'observacoes' => array(
				'label' => 'Observações',
				'type' => 'Textarea',
				'required' => false,
			),
			'ordem_compra' => array(
				'type' => 'Text',
				'label' => 'Ordem de Compra',
			),
			'tipo_reservatorio' => array(
				'type' => 'Select',
				'label' => 'Tipo de Reservatório',
				'option' => array('' => 'Não informado'),
				'options' => $this->_tipo_reservatorio,
			),
			'acesso' => array(
				'type' => 'Select',
				'label' => 'Acesso ao ponto de coleta',
				'option' => array('' => 'Não informado'),
				'options' => $this->_acesso,
			),
			'metragem_mangueira' => array(
				'type' => 'Text',
				'label' => 'Metragem de Mangueira necessária',
			),
			'situacao_tampas' => array(
				'type' => 'Text',
				'label' => 'Situação das Tampas',
			),
			'situacao_efluentes' => array(
				'type' => 'Select',
				'label' => 'Situação dos Efluentes',
				'option' => array('' => 'Não informado'),
				'options' => $this->_situacao_efluentes,
			),
			'observacoes_poscoleta' => array(
				'label' => 'Observações Pós Coleta',
				'type' => 'Textarea',
			),
			'horas_trabalhadas' => array(
				'type' => 'Text',
				'label' => 'Horas Trabalhadas',
			),
			'checagem_final' => array(
				'type' => 'Select',
				'label' => 'Checagem Final',
				'option' => array('' => 'Não informado'),
				'options' => $this->_checagem_final,
			),
			'faturado' => array(
				'type' => 'Select',
				'label' => 'Faturada',
				'options' => $this->_faturado,
			),
			'observacao_faturamento' => array(
				'label' => 'Observações para Faturamento',
				'type' => 'Textarea',
			),
		);
	}

	public function adjustToView(array $data)
	{
		$data['codigo'] = $data['orcamento_id'] . '.' . $data['sequencial'];
		switch ($data['status']):
			case 1:
				$WD = new WS_Date();
				$Vencimento = new WS_Date($data['data_coleta']);
				if ($Vencimento->compare($WD->today()) !== 1):
					$data['class'] = 'atrasada';
				endif;
				break;
			case 2:
				$data['class'] = 'aberto';
				break;
			case 3:
				$data['class'] = 'pago';
				break;
			default:
				break;
		endswitch;
		return parent::adjustToView($data);
	}

	public function ajusteRelatorioFepan($item)
	{
		$ZD = new Zend_Date($item['data_coleta']);
		$ZD->add(4, Zend_DATE::DAY);
		$CertificadosModel = new Certificados_Model();

		$retorno[0] = WS_Date::adjustToView($item['data_coleta']);
		$retorno[1] = utf8_decode($item['cliente_nome'] . ' ' . $item['cliente_endereco'] . ' ' . $item['cliente_cidade']);
		$retorno[2] = utf8_decode($item['transportador_nome'] . " - LO Nº " . $item['transportador_lo']);
		$retorno[3] = utf8_decode($item['quantidade'] . ' m³');
		$retorno[4] = utf8_decode($CertificadosModel->getOption('tipo_efluente', $item['tipo_efluente']));
		$retorno[5] = WS_Date::adjustToView($item['data_coleta']) . ' - ' . substr($ZD->__toString('dd/MM/yyyy'), 0, 10);
		$retorno[6] = $item['mtr'];
		$retorno[7] = $item['id'] . '.' . $item['sequencial'];
		return $retorno;
	}

	public function ajusteRelatorio(array $itens)
	{
		$WD = new WS_Date();
		$total = array('domestico' => 0, 'industrial' => 0, 'residuos' => 0);
		foreach ($itens AS $item):
			$var['item_status'] = $this->getOption('status', $item['status']);
			$var['item_codigo'] = $item['orcamento_id'] . '.' . $item['id'];
			$var['item_data'] = WS_Date::adjustToView($item['data_coleta']);
			$var['item_cliente'] = $item['razao_social'];
			$total['domestico'] += $var['item_volume_domestico'] = $this->volumeDomestico($item['id']);
			$total['industrial'] += $var['item_volume_industrial'] = $this->volumeIndustrial($item['id']);
			$total['residuos'] += $var['item_volume_residuos'] = $this->volumeResiduos($item['id']);
			$retorno[] = $var;
		endforeach;

		$retorno['total_domestico'] = $total['domestico'];
		$retorno['total_industrial'] = $total['industrial'];
		$retorno['total_residuos'] = $total['residuos'];

		return $retorno;
	}

	public function montaRelatorio($data, $formato = 'pdf')
	{
		$WD = new WS_Date();
		if ($formato == 'pdf'):
			$itens = $this->relatorio($data);
			$itens = $this->ajusteRelatorio($itens);
			try {
				$phpLiveDocx = new WS_LiveDocx_Model();
				$phpLiveDocx->setRemoteTemplate('RelatorioOrdensServico.docx');
				$phpLiveDocx
					->assign('data_inicial', WS_Date::adjustToView($data['data_inicial']))
					->assign('data_final', WS_Date::adjustToView($data['data_final']))
					->assign('total_domestico', $itens['total_domestico'])
					->assign('total_industrial', $itens['total_industrial'])
					->assign('total_residuos', $itens['total_residuos']);

				unset($itens['total_domestico']);
				unset($itens['total_industrial']);
				unset($itens['total_residuos']);

				$phpLiveDocx->assign('item', $itens)
					->assign('total', count($itens));
				$phpLiveDocx->createDocument();
				$document = $phpLiveDocx->retrieveDocument($formato);
				return $document;
			} catch (Zend_Service_LiveDocx_Exception $e) {
				return $e->getMessage();
			}
		else:
			$itens = $this->relatorioFepan($data);

			$arquivo = UPLOAD_PATH . '/' . 'RelatorioOrdensServico' . date('U') . '.csv';
			$fp = fopen($arquivo, 'w');
			$cabecalho = array(
				'DATA DO RECEBIMENTO',
				utf8_decode('ORIGEM (RAZÃO SOCIAL E ENDEREÇO)'),
				'EMPRESA TRANSPORTADORA',
				'VOL.EFLUENTE RECEBIDO',
				'TIPO DE EFLUENTE',
				utf8_decode('DATA E PERÍODO DE TRATAMENTO'),
				'MTR',
				'CERTIFICADO'
			);
			fputcsv($fp, $cabecalho, ';', '"');
			foreach ($itens as $line) {
				$line = $this->ajusteRelatorioFepan($line);
				fputcsv($fp, $line, ';', '"');
			}
			fclose($fp);
			return $arquivo;
		endif;
	}

	public function somaValores($orcamento_id)
	{
		$sql = $this->_db->select()
			->from(array('os' => 'ordens_servico'), array('soma' => '(SUM(os.valor) - SUM(os.desconto))'))
			->where('os.orcamento_id = ?', $orcamento_id);
		$item = $sql->query()->fetch();
		return (!empty($item)) ? $item : false;
	}

	public function relatorio($data)
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('data_coleta', 'status', 'id', 'orcamento_id', 'sequencial'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array())
			->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social'))
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente_id' => 'id', 'cliente' => 'razao_social'))
			->joinLeft(array('m' => 'mtrs'), 'os.id = m.ordem_servico_id', array('mtr'))
			->joinLeft(array('cer' => 'certificados'), 'm.id = cer.mtr_id', array('certificado_id' => 'id'))
			->order('os.data_coleta ASC')
			->group('os.id')
			->where('os.data_coleta >= ?', WS_Date::adjustToDb($data['data_inicial']))
			->where('os.data_coleta <= ?', WS_Date::adjustToDb($data['data_final']));

		if (!empty($data['status'])):
			$consulta->where('os.status = ?', $data['status']);
		endif;
		if (!empty($data['cliente_id'])):
			$consulta->where('c.id = ?', $data['cliente_id']);
		endif;
		if (!empty($data['empresa_id'])):
			$consulta->where('e.id = ?', $data['empresa_id']);
		endif;
		$itens = $consulta->query()->fetchAll();
		return $itens;
	}

	public function relatorioFepan($data)
	{
		$WD = new WS_Date();
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('data_coleta'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('id'))
			->joinInner(array('m' => 'mtrs'), 'os.id = m.ordem_servico_id', array('mtr'))
			->joinInner(array('c' => 'certificados'), 'm.id = c.mtr_id', array('cliente_nome', 'cliente_endereco', 'cliente_cidade', 'sequencial', 'tipo_efluente', 'quantidade', 'transportador_nome', 'transportador_lo'))
			->order('os.data_coleta ASC')
			->where('os.data_coleta >= ?', WS_Date::adjustToDb($data['data_inicial']))
			->where('os.data_coleta <= ?', WS_Date::adjustToDb($data['data_final']));
		if (!empty($data['status'])):
			$consulta->where('os.status = ?', $data['status']);
		endif;
		$itens = $consulta->query()->fetchAll();
		return $itens;
	}

	public function volumeResiduos($ordem_servico_id)
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array(''))
			->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(qtde)'))
			->joinInner(array('s' => 'servicos'), 'oss.servico_id = s.id', array(''))
			->where('os.id = ?', $ordem_servico_id)
			->where('s.tipo IN ("R","D","I")')
			->group('os.id');
		$item = $consulta->query()->fetch();
		return ($item['volume']) ? $item['volume'] : '0.0';
	}

	public function volumeDomestico($ordem_servico_id)
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array(''))
			->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(qtde)'))
			->joinInner(array('s' => 'servicos'), 'oss.servico_id = s.id', array(''))
			->where('os.id = ?', $ordem_servico_id)
			->where('s.tipo = ?', 'D')
			->group('os.id');

		$item = $consulta->query()->fetch();
		return ($item['volume']) ? $item['volume'] : '0.0';
	}

	public function volumeIndustrial($ordem_servico_id)
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array(''))
			->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(qtde)'))
			->joinInner(array('s' => 'servicos'), 'oss.servico_id = s.id', array(''))
			->where('os.id = ?', $ordem_servico_id)
			->where('s.tipo = ?', 'I')
			->group('os.id');
		$item = $consulta->query()->fetch();
		return ($item['volume']) ? $item['volume'] : '0.0';
	}

	public function transporte($ordem_servico_id)
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array(''))
			->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(qtde)'))
			->joinInner(array('s' => 'servicos'), 'oss.servico_id = s.id', array(''))
			->where('os.id = ?', $ordem_servico_id)
			->where('s.tipo = ?', 'T')
			->group('os.id');
		$item = $consulta->query()->fetch();
		return ($item['volume']) ? $item['volume'] : '0.0';
	}

	public function getSequencial($orcamento_id)
	{
		$consulta = $this->_db->select()
			->from(array('os' => 'ordens_servico'), array('sequencial' => 'MAX(sequencial)'))
			->where('os.orcamento_id = ?', $orcamento_id);
		$item = $consulta->query()->fetch();
		return $item;
	}

	public function osAtrasadas()
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->joinInner(array('os' => 'ordens_servico'), array('id', 'sequencial', 'data_coleta', 'hora_coleta'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array())
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
			->where('os.data_coleta < ?', date('Y-m-d'))
			->where('os.status = 1')
			->order('os.data_coleta ASC');
		$itens = $consulta->query()->fetchAll();
		return $itens;
	}

	public function osVencendo()
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->joinInner(array('os' => 'ordens_servico'), array('id', 'sequencial', 'data_coleta', 'hora_coleta'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
			->where('os.data_coleta <= ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 15, date('Y'))))
			->where('os.data_coleta >= ?', date('Y-m-d'))
			->where('os.status = 1')
			->order('os.data_coleta ASC');
		$itens = $consulta->query()->fetchAll();
		return $itens;
	}

	public function buscarPorOrcamento($orcamento_id, $faturado = NULL)
	{
		$sql = clone($this->_basicSearch);
		$sql->where('os.orcamento_id = ?', $orcamento_id)
			->order('os.data_coleta ASC');
		if ($faturado):
			$sql->where('os.faturado = ?', 'N');
		endif;
		$itens = $sql->query()->fetchAll();
		return $itens;
	}

	public function buscarPorConta($conta_id)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('id', 'sequencial'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('orcamento_id' => 'id'))
			->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
			->where('cros.conta_receber_id = ?', $conta_id)
			->order('os.data_coleta ASC');
		$itens = $sql->query()->fetchAll();
		return $itens;
	}

	public function buscarPorCte($cte_id)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('id', 'sequencial'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('orcamento_id' => 'id'))
			->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
			->joinInner(array('cr' => 'contas_receber'), 'cr.id = cros.conta_receber_id', array(''))
			->where('cr.cte_id = ?', $cte_id)
			->order('os.data_coleta ASC')
			->group('os.id');
		$itens = $sql->query()->fetchAll();
		return $itens;
	}

	public function buscarPorCteAcqualife($cte_id)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('id', 'sequencial'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('orcamento_id' => 'id'))
			->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
			->joinInner(array('cr' => 'contas_receber'), 'cr.id = cros.conta_receber_id', array(''))
			->where('cr.cte_acqualife_id = ?', $cte_id)
			->order('os.data_coleta ASC')
			->group('os.id');
		$itens = $sql->query()->fetchAll();
		return $itens;
	}

	public function buscarDadosPorOrcamento($orcamento_id)
	{
		$consulta = $this->_db->select()
			->from(array('os' => 'ordens_servico'), array('total' => 'COUNT(os.id)', 'soma' => 'SUM(os.valor)-SUM(os.desconto)'))
			->where('os.orcamento_id = ?', $orcamento_id);
		$item = $consulta->query()->fetch();
		return $item;
	}

	public function find($ordem_servico_id)
	{
		$consulta = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('*'))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('cliente_id'))
			->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social', 'endereco', 'numero', 'complemento', 'bairro', 'cep', 'telefone', 'telefone2', 'telefone3', 'logomarca', 'website', 'email'))
			->joinInner(array('mu' => 'municipios'), 'mu.id = e.municipio_id', array('cidade' => 'nome'))
			->joinInner(array('es' => 'estados'), 'es.id = e.estado_id', array('uf'))
			->joinInner(array('t' => 'transportadores'), 't.id = os.transportador_id', array('transportador' => 'razao_social'))
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'contato', 'sindico', 'zelador'))
			->where('os.id = ?', $ordem_servico_id);

		$item = $consulta->query()->fetch();
		return $item;
	}

	public function buscarPorCliente($cliente_id, $concluidos = NULL)
	{
		$sql = clone($this->_basicSearch);
		$sql->where('o.cliente_id = ?', $cliente_id);
		if ($concluidos):
			$sql->where('os.status = ?', '3');
		endif;
		$itens = $sql->query()->fetchAll();
		return $itens;
	}

	public function eventos($inicio, $fim)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico', array('id', 'data_coleta', 'hora_coleta')))
			->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array())
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
			->where('os.data_coleta >= ?', $inicio)
			->where('os.data_coleta <= ?', $fim);
		$items = $sql->query()->fetchAll();
		return $items;
	}

	public function getLastByClient($cliente_id)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('o' => 'orcamentos'), array('data_emissao'))
			->joinLeft(array('os' => 'ordens_servico'), 'o.id = os.orcamento_id', array('data_coleta'))
			->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array(''))
			->where('c.id = ?', $cliente_id)
			->order('os.data_coleta DESC')
			->order('o.data_emissao DESC')
			->where('(os.status = 3 AND data_coleta != "") OR (data_emissao != "")')
			->limit(1);
		return $sql->query()->fetch();
	}

	public function getByCte($cte_id)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('c' => 'ctes'), array(''))
			->joinInner(array('cr' => 'contas_receber'), 'c.id = cr.cte_id', array(''))
			->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'cr.id = cros.conta_receber_id', array(''))
			->joinInner(array('os' => 'ordens_servico'), 'os.id = cros.ordem_servico_id', array('id'))
			->group('os.id')
			->where('c.id = ?', $cte_id);

		$items = $sql->query()->fetchAll();
		return $items;
	}

	public function getByCteAcqualife($cte_id)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('c' => 'ctes'), array(''))
			->joinInner(array('cr' => 'contas_receber'), 'c.id = cr.cte_acqualife_id', array(''))
			->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'cr.id = cros.conta_receber_id', array(''))
			->joinInner(array('os' => 'ordens_servico'), 'os.id = cros.ordem_servico_id', array('id'))
			->group('os.id')
			->where('c.id = ?', $cte_id);

		$items = $sql->query()->fetchAll();
		return $items;
	}

	public function getVolumeByClienteCategoria($inicio, $fim)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array(''))
			->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(qtde)'))
			->joinInner(array('s' => 'servicos'), 'oss.servico_id = s.id AND s.certificado = "S"', array(''))
			->joinInner(array('o' => 'orcamentos'), 'os.orcamento_id = os.id', array(''))
			->joinInner(array('c' => 'clientes'), 'o.cliente_id = c.id', array(''))
			->joinInner(array('cc' => 'clientes_categorias'), 'c.categoria_id = cc.id', array('categoria'))
			->joinInner(array('cr' => 'contas_receber'), 'cr.orcamento_id = o.id', array(''))
			->where('cr.data_pagamento >= ?', $inicio)
			->where('cr.data_pagamento <= ?', $fim)
			->group('cc.id')
			->order('categoria');
		$items = $sql->query()->fetchAll();
		return $items;
	}

	public function getVolumeTotal($inicio, $fim)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array(''))
			->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(qtde)'))
			->joinInner(array('s' => 'servicos'), 'oss.servico_id = s.id AND s.certificado = "S"', array(''))
			->joinInner(array('o' => 'orcamentos'), 'os.orcamento_id = os.id', array(''))
			->joinInner(array('c' => 'clientes'), 'o.cliente_id = c.id', array(''))
			->joinInner(array('cc' => 'clientes_categorias'), 'c.categoria_id = cc.id', array(''))
			->joinInner(array('cr' => 'contas_receber'), 'cr.orcamento_id = o.id', array(''))
			->where('cr.data_pagamento >= ?', $inicio)
			->where('cr.data_pagamento <= ?', $fim);
		$item = $sql->query()->fetch();
		return $item;
	}

	public function buscaFaturamento($data)
	{
		$sql = $this->_db->select()
			->setIntegrityCheck(false)
			->from(array('os' => 'ordens_servico'), array('faturado' => 'SUM(valor)'));

		if (!empty($data['data_inicial'])):
			$sql->where('os.data_coleta >= ?', WS_Date::adjustToDb($data['data_inicial']));
		endif;
		if (!empty($data['data_final'])):
			$sql->where('os.data_coleta <= ?', WS_Date::adjustToDb($data['data_final']));
		endif;

		$item = $sql->query()->fetch();
		return $item;
	}

}
