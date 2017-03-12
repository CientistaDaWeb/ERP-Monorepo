<?php

class Orcamentos_Model extends WS_Model {

    protected $_status;
    protected $_vantagens;

    public function __construct() {
        $this->_db = new Orcamentos_Db();
        $this->_title = 'Gerenciador de Orçamentos';
        $this->_singular = 'Orçamento';
        $this->_plural = 'Orçamentos';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'o.id';

        $this->_status = array(
            1 => 'Rascunho',
            2 => 'Aguardando Aprovação',
            3 => 'Aprovado',
            4 => 'Não Aprovado'
        );
        $this->_vantagens = array(
            'S' => 'Sim',
            'N' => 'Não'
        );

        parent::__construct();
    }

    public function adjustToView(array $data) {
        $ContasReceberModel = new ContasReceber_Model();
        $contas = $ContasReceberModel->buscarDadosPorOrcamento($data['id']);

        $OrdensSevicoModel = new OrdensServico_Model();
        $os = $OrdensSevicoModel->buscarDadosPorOrcamento($data['id']);

        $data['saldo'] = WS_Money::adjustToView($contas['soma'] - $os['soma']);
        $data['nFat'] = $contas['total'];
        $data['nOS'] = $os['total'];
        $data['totFat'] = $contas['soma'];
        $data['totOs'] = $os['soma'];
        switch ($data['status']) {
            case 2:
                $data['class'] = 'aberto';
                break;
            case 3:
                $data['class'] = 'pago';
                break;
            case 4:
                $data['class'] = 'atrasada';
                break;
            default:
                break;
        }
        return parent::adjustToView($data);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('*'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'cliente_id' => 'id'))
                ->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social'))
                ->order('o.data_emissao DESC')
                ->group('o.id');
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'status' => 'asc',
            'data_emissao' => 'desc',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_emissao' => 'date',
            'valor_total' => 'money',
            'status' => 'getOption'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'o.id' => 'text',
            'c.razao_social' => 'text',
            'c.nome_fantasia' => 'text',
            'o.data_emissao' => 'date'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'empresa_id' => array(
                'label' => 'Empresa',
                'type' => 'Select',
                'option' => array('' => 'Selecione a empresa ...'),
                'options' => Empresas_Model::fetchPair(),
                'required' => true
            ),
            'cliente_id' => array(
                'label' => 'Cliente',
                'type' => 'Select',
                'option' => array('' => 'Selecione o cliente ...'),
                'options' => Clientes_Model::fetchPair(),
                'required' => true
            ),
            'usuario_id' => array(
                'label' => 'Funcionário',
                'type' => 'Select',
                'options' => Usuarios_Model::fetchPair(),
                'required' => true
            ),
            'valor_total' => array(
                'label' => 'Valor Total (caso tenha negociado um valor fechado)',
                'type' => 'Money'
            ),
            'data_emissao' => array(
                'label' => 'Data de Emissão',
                'type' => 'Date',
                'required' => true
            ),
            'vantagens' => array(
                'label' => 'Exibir as vantagens no Orçamento',
                'type' => 'Select',
                'options' => Orcamentos_Model::listOptions('vantagens')
            ),
            'status' => array(
                'label' => 'Status do Orçamento',
                'type' => 'Select',
                'options' => Orcamentos_Model::listOptions('status'),
                'required' => true
            )
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'id' => 'Código',
            'cliente' => 'Cliente',
            'empresa' => 'Empresa',
            'data_emissao' => 'Data de Emissão',
            'status' => 'Status',
            'nOS' => 'Nº OS',
            'nFat' => 'Nº Fat',
            'saldo' => 'Saldo'
        );
    }

    public function ajusteConfiguracao($data) {
        unset($data['titulo_id']);
        unset($data['condicao_pagamento_id']);
        unset($data['prazo_entrega_id']);
        unset($data['observacao_id']);
        return $data;
    }

    public function setStatus($id, $status) {
        $data['status'] = $status;
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update($data, $where);
    }

    public function buscaCliente($orcamento_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('cliente_id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('email', 'contato'))
                ->where('o.id = ?', $orcamento_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function find($id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('*'))
                ->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social', 'endereco', 'numero', 'complemento', 'bairro', 'cep', 'telefone', 'telefone2', 'telefone3', 'logomarca', 'site', 'email'))
                ->joinInner(array('mu' => 'municipios'), 'mu.id = e.municipio_id', array('cidade' => 'nome'))
                ->joinInner(array('es' => 'estados'), 'es.id = e.estado_id', array('uf'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente' => 'razao_social', 'contato'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = o.usuario_id', array('fnome' => 'nome', 'fcargo' => 'cargo', 'ftelefone' => 'telefone', 'femail' => 'email'))
                ->where('o.id = ?', $id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function orcamentosAbertos() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('data_emissao', 'id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = o.usuario_id', array('nome'))
                ->where('o.status = 2')
                ->order('data_emissao ASC');
        return $consulta->query()->fetchAll();
    }

    public function buscarPorCliente($cliente_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('id', 'data_emissao', 'status'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
                ->joinLeft(array('cr' => 'contas_receber'), 'o.id = cr.orcamento_id', array('totFat' => 'SUM(cr.valor)', 'nFat' => 'COUNT(cr.id)'))
                ->joinLeft(array('os' => 'ordens_servico'), 'o.id = os.orcamento_id', array('totOS' => 'SUM(os.valor)-SUM(os.desconto)', 'nOS' => 'COUNT(os.id)'))
                ->group('o.id')
                ->where('c.id = ?', $cliente_id)
                ->order('o.data_emissao DESC');
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function gerarPdf($id, $timbrado = false) {
        $ServicosModel = new Servicos_Model();
        $servicos = $ServicosModel->buscarPorOrcamento($id);

        $orcamento = $this->find($id);

        $empresa_endereco = $orcamento['endereco'] . ', ' . $orcamento['numero'] . ' ' . $orcamento['complemento'] . ' - ' . $orcamento['bairro'];
        $empresa_cidade = $orcamento['cep'] . ' ' . $orcamento['cidade'] . ' - ' . $orcamento['uf'];
        $empresa_telefone = $orcamento['telefone'];

        if (!empty($orcamento['telefone2'])):
            $empresa_telefone .= ' | ' . $orcamento['telefone2'];
        endif;

        if (!empty($orcamento['telefone3'])):
            $empresa_telefone .= ' | ' . $orcamento['telefone3'];
        endif;

        $ZD = new Zend_Date($orcamento['data_emissao']);

        $phpLiveDocx = new WS_LiveDocx_Model();

        if (!$timbrado):
            $template = realpath('../livedocx/Orcamento.docx');
            $phpLiveDocx->setLocalTemplate($template);
        //$phpLiveDocx->setRemoteTemplate('Orcamento.docx');
        else:
            $template = realpath('../livedocx/OrcamentoTimbrado.docx');
            $phpLiveDocx->setLocalTemplate($template);
        endif;

        $photoFilename = $orcamento['logomarca'];

        if (!$phpLiveDocx->imageExists($photoFilename)) :
            $phpLiveDocx->uploadImage('http://www.acquasana.com.br/images/logos/' . $photoFilename);
        endif;

        if ($orcamento['vantagens'] == 'S'):
            $imgVantagens = 'vantagens.jpg';
            $phpLiveDocx->uploadImage('http://www.acquasana.com.br/images/' . $imgVantagens);
            $phpLiveDocx->assign('image:vantagens', $imgVantagens);
        endif;

        $phpLiveDocx
                ->assign('image:logo', $photoFilename)
                ->assign('orcamento_id', $orcamento['id'])
                ->assign('empresa_nome', $orcamento['empresa'])
                ->assign('empresa_endereco', $empresa_endereco)
                ->assign('empresa_cidade', $empresa_cidade)
                ->assign('empresa_telefone', $empresa_telefone)
                ->assign('empresa_email', $orcamento['email'])
                ->assign('empresa_site', $orcamento['site'])
                ->assign('data_emissao', $ZD->toString('dd/MM/YYYY'))
                ->assign('cliente_nome', $orcamento['cliente'])
                ->assign('cliente_contato', $orcamento['contato'])
                ->assign('titulo', $orcamento['titulo'])
                ->assign('servico', $servicos)
                ->assign('condicoes_pagamento', $orcamento['condicoes_pagamento'])
                ->assign('validade_proposta', $orcamento['prazo_entrega'])
                ->assign('observacoes', $orcamento['observacoes'])
                ->assign('funcionario_nome', $orcamento['fnome'])
                ->assign('funcionario_cargo', $orcamento['fcargo'])
                ->assign('funcionario_telefone', $orcamento['ftelefone'])
                ->assign('funcionario_email', $orcamento['femail'])
        ;
        if ($orcamento['valor_total'] != "0.00"):
            $phpLiveDocx->assign('total', $orcamento['valor_total']);
        else:
            $phpLiveDocx->assign('total', '---');
        endif;

        $phpLiveDocx->createDocument();

        $document = $phpLiveDocx->retrieveDocument('pdf');
        $arquivo = 'Orcamento_' . $orcamento['id'] . '.pdf';
        if (!$timbrado):
            file_put_contents(UPLOAD_PATH . 'orcamentos/' . $arquivo, $document);
            return true;
        else:
            return $document;
        endif;
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('data_emissao', 'status', 'id'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = o.usuario_id', array('nome'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente_id' => 'id', 'cliente' => 'razao_social'))
                ->joinInner(array('e' => 'empresas'), 'e.id = o.empresa_id', array('empresa' => 'razao_social'))
                ->joinLeft(array('os' => 'ordens_servico'), 'o.id = os.orcamento_id', array('nOS' => 'COUNT(os.id)', 'totalOS' => 'SUM(os.valor)'))
                ->joinLeft(array('cr' => 'contas_receber'), 'o.id = cr.orcamento_id', array('nFat' => 'COUNT(cr.id)', 'totalFat' => 'SUM(cr.valor)', 'totalRet' => 'SUM(cr.valor_retido)'))
                ->order('o.data_emissao ASC')
                ->where('o.data_emissao >= ?', WS_Date::adjustToDb($data['data_inicial']))
                ->where('o.data_emissao <= ?', WS_Date::adjustToDb($data['data_final']))
                ->group('o.id');

        if (!empty($data['status'])):
            $consulta->where('o.status = ?', $data['status']);
        endif;

        if (!empty($data['usuario_id'])):
            $consulta->where('u.id = ?', $data['usuario_id']);
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

    public function montaRelatorio($data, $formato = 'pdf') {
        $WD = new WS_Date();
        try {
            $itens = $this->relatorio($data);
            $itens = $this->adjustToView($itens);

            $phpLiveDocx = new WS_LiveDocx_Model();
            $template = realpath('../livedocx/RelatorioOrcamentos.docx');
            $phpLiveDocx->setLocalTemplate($template);
            //$phpLiveDocx->setRemoteTemplate('RelatorioOrcamentos.docx');

            $phpLiveDocx
                    ->assign('data_inicial', WS_Date::adjustToView($data['data_inicial']))
                    ->assign('data_final', WS_Date::adjustToView($data['data_final']))
                    ->assign('total', count($itens))
                    ->assign('item', $itens);
            $phpLiveDocx->createDocument();

            $document = $phpLiveDocx->retrieveDocument($formato);
            return $document;
        } catch (Zend_Service_LiveDocx_Exception $e) {
            return $e->getMessage();
        }
    }

    public function divergencias() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('o' => 'orcamentos'), array('*'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = o.usuario_id', array('nome'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('cliente_id' => 'id', 'cliente' => 'razao_social'))
                ->where('o.status = 3')
                ->group('o.id');
        $orcamentos = $consulta->query()->fetchAll();
        if (!empty($orcamentos)):
            $retorno = array();
            $ContasReceberModel = new ContasReceber_Model();
            $OrdensServicoModel = new OrdensServico_Model();
            foreach ($orcamentos AS $orcamento):
                $contas = $ContasReceberModel->somaValores($orcamento['id']);
                $os = $OrdensServicoModel->somaValores($orcamento['id']);
                $orcamento['saldo'] = $contas['soma'] - $os['soma'];
                if ($orcamento['saldo'] < -1 || $orcamento['saldo'] > 1):
                    $orcamento['saldo'] = WS_Money::adjustToView($orcamento['saldo']);
                    $retorno[] = $orcamento;
                endif;
            endforeach;
            return $retorno;
        endif;
    }

}
