<?php

class Clientes_Model extends WS_Model {

    protected $_tipo;

    public function __construct() {
        $this->_db = new Clientes_Db();
        $this->_title = 'Gerenciador de Clientes';
        $this->_singular = 'Cliente';
        $this->_plural = 'Clientes';
        $this->_layoutForm = false;
        $this->_layoutList = 'basic';
        $this->_primary = 'c.id';

        $this->_documento_tipo = array(
            1 => 'Pessoa Jurídica',
            2 => 'Pessoa Física'
        );

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'clientes'), array('*'))
                ->joinLeft(array('o' => 'orcamentos'), 'c.id = o.cliente_id', array('orcamentos' => 'COUNT(o.id)'))
                ->joinLeft(array('ct' => 'clientes_telefones'), 'c.id = ct.cliente_id', array(''))
                ->joinLeft(array('cc' => 'clientes_categorias'), 'cc.id = c.categoria_id', array('categoria'))
                ->group('c.id')
        ;
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'c.razao_social' => 'asc'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'categoria_id' => array(
                'type' => 'Select',
                'label' => 'Categoria de Cliente',
                'options' => ClientesCategorias_Model::fetchPair(),
                'required' => true
            ),
            'documento_tipo' => array(
                'type' => 'Select',
                'label' => 'Tipo de Cliente',
                'options' => self::listOptions('documento_tipo'),
                'required' => true
            ),
            'documento' => array(
                'type' => 'Cnpj',
                'label' => 'CPF/CNPJ',
                'required' => true
            ),
            'razao_social' => array(
                'type' => 'Text',
                'label' => 'Razão Social/Nome',
                'required' => true
            ),
            'nome_fantasia' => array(
                'type' => 'Text',
                'label' => 'Nome Fantasia',
                'required' => true
            ),
            'inscricao_estadual' => array(
                'type' => 'Text',
                'label' => 'Inscrição Estadual',
            ),
            'contato' => array(
                'type' => 'Text',
                'label' => 'Contato',
                'required' => true
            ),
            'email' => array(
                'type' => 'Mail',
                'label' => 'E-mail',
                'required' => true
            ),
            'email_cobranca' => array(
                'type' => 'Mail',
                'label' => 'E-mail de Cobrança',
                'required' => true
            ),
            'email_pesquisa' => array(
                'type' => 'Mail',
                'label' => 'E-mail de Pesquisa',
                'required' => true
            ),
            'site' => array(
                'type' => 'Url',
                'label' => 'Site',
            ),
            'numero_fepan' => array(
                'type' => 'Text',
                'label' => 'Nº da Fepan',
            ),
            'sindico' => array(
                'type' => 'Text',
                'label' => 'Síndico',
            ),
            'zelador' => array(
                'type' => 'Text',
                'label' => 'zelador',
            ),
            'administrador_id' => array(
                'type' => 'Select',
                'label' => 'Administrador de Condomínio',
                'option' => array('' => 'Sem Administração'),
                'options' => AdministradoresCondominios_Model::fetchPair()
            ),
            'usuario' => array(
                'type' => 'Text',
                'label' => 'Usuário',
                'required' => true
            ),
            'senha' => array(
                'type' => 'Text',
                'label' => 'Senha',
                'required' => true
            ),
            'observacoes' => array(
                'label' => 'Observações',
                'type' => 'Textarea',
                'required' => false,
            ),
            'observacoes_faturamento' => array(
                'label' => 'Observações de Faturamento',
                'type' => 'Textarea',
                'required' => false,
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'razao_social' => 'Razão Social/Nome',
            'contato' => 'Contato',
            'categoria' => 'Categoria',
            'telefones' => 'Telefones',
            'enderecos' => 'Endereços',
            'orcamentos' => 'Nº Orç.',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'c.razao_social' => 'text',
            'c.nome_fantasia' => 'text',
            'c.contato' => 'text',
            'ct.telefone' => 'text',
            'cc.categoria' => 'text',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'administrador_id' => 'int'
        );
        return parent::setAdjustFields();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $consulta = $db->select()
                ->from('clientes', array('id', 'razao_social'))
                ->order('razao_social');
        return $db->fetchPairs($consulta);
    }

    public function adjustToView(array $data) {
        $ClientesTelefonesModel = new ClientesTelefones_Model();
        $ClientesEnderecosModel = new ClientesEnderecos_Model();

        $telefones = $ClientesTelefonesModel->buscaTelefones($data['id']);
        foreach ($telefones AS $telefone):
            $tel[] = '<a href="tel:+55' . WS_Text::onlyNumber($telefone['telefone']) . '">' . str_replace('.', '-', $telefone['telefone']) . '</a>';
            //$tel[] = str_replace('.', '-', $telefone['telefone']);
        endforeach;
        $data['telefones'] = join(' | ', $this->arrayImplode($tel));

        $enderecos = $ClientesEnderecosModel->getSumByClient($data['id']);
        $data['enderecos'] = $enderecos['total'];

        if ($data['enderecos'] == 0):
            $data['enderecos'] = 'Não possui';
        endif;

        return parent::adjustToView($data);
    }

    public function ajusteRelatorioCondominio($data) {
        $ClientesTelefonesModel = new ClientesTelefones_Model();
        $telefones = $ClientesTelefonesModel->buscaTelefones($data['id']);
        $data['telefones'] = join(' | ', $this->arrayImplode($telefones));

        $data['enderecos'] = '';
        $item['endereco'] = '';
        $clientesEnderecosModel = new ClientesEnderecos_Model();
        $enderecos = $clientesEnderecosModel->buscarPorCliente($data['id']);
        if (!empty($enderecos)):
            foreach ($enderecos AS $endereco):
                $item['endereco'] .= $endereco['endereco'] . ', ' . $endereco['numero'] . ' ' . $endereco['complemento'] . ' - ' . $endereco['bairro'] . ' | ' . $endereco['cidade'] . ' - ' . $endereco['uf'] . '<br />';
            endforeach;
            $data['enderecos'] = $item['endereco'];
        endif;
        return $data;
    }

    public function buscarPorOrcamento($orcamento_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'clientes'), array('email', 'contato', 'cliente_id' => 'id'))
                ->joinInner(array('o' => 'orcamentos'), 'c.id = o.cliente_id', array(''))
                ->where('o.id = ?', $orcamento_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function relatorioAdministradores($administrador_id = '') {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'clientes'), array('*'));
        if (!empty($administrador_id)):
            $consulta->where('c.administrador_id = ?', $administrador_id);
        endif;
        $consulta->order('c.razao_social');

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function geraRandomico() {
        $CaracteresAceitos = '0123456789';
        $max = strlen($CaracteresAceitos) - 1;
        $password = null;
        for ($i = 0; $i < 4; $i++) {
            $password .= $CaracteresAceitos{mt_rand(0, $max)};
        }
        return $password;
    }

    public function relatorio() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'clientes'), array('razao_social', 'id'))
                ->joinLeft(array('ac' => 'administradores_condominios'), 'ac.id = c.administrador_id', array('administrador' => 'nome'))
                ->order('c.razao_social');
        return $consulta->query()->fetchAll();
    }

    public function relatorioAtendidos($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'clientes'), array('cliente' => 'razao_social', 'cliente_id' => 'id'))
                ->joinInner(array('o' => 'orcamentos'), 'c.id = o.cliente_id', array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'o.id = os.orcamento_id', array('os' => 'COUNT(os.id)'))
                ->joinLeft(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(oss.qtde)'))
                ->joinLeft(array('s' => 'servicos'), 's.id = oss.servico_id AND s.certificado = "S"', array(''))
                ->order('c.razao_social')
                ->group('c.id');

        if (!empty($data['data_inicial'])):
            $consulta->where('os.data_coleta >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('os.data_coleta <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        return $consulta->query()->fetchAll();
    }

    public function relatorioCadastrados($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'clientes'), array('cliente' => 'razao_social', 'cliente_id' => 'id'))
                ->joinLeft(array('ce' => 'clientes_enderecos'), 'c.id = ce.cliente_id', array(''))
                ->joinLeft(array('m' => 'municipios'), 'm.id = ce.municipio_id', array('cidade' => 'nome'))
                ->joinLeft(array('cc' => 'clientes_categorias'), 'cc.id = c.categoria_id', array('categoria'))
                ->order('c.razao_social')
                ->group('c.id');

        if (!empty($data['data_inicial'])):
            $consulta->where('c.created >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('c.created <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        return $consulta->query()->fetchAll();
    }

    public function ajusteRelatorio($data) {
        $OrdensServicoModel = new OrdensServico_Model();
        $OrdemServico = $OrdensServicoModel->getLastByClient($data['id']);
        if (!empty($OrdemServico['data_coleta'])):
            $data['ordem_servico'] = WS_Date::adjustToView($OrdemServico['data_coleta']);
        else:
            $data['ordem_servico'] = '';
        endif;
        if (!empty($OrdemServico['data_emissao'])):
            $data['orcamento'] = WS_Date::adjustToView($OrdemServico['data_emissao']);
        else:
            $data['orcamento'] = '';
        endif;
        return $data;
    }

}
