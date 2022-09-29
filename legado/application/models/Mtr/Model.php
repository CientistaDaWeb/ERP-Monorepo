<?php

class Mtr_Model extends WS_Model {

    protected $_dono;
    protected $_certificado;
    protected $_residuos;

    public function __construct() {
        $this->_db = new Mtr_Db();
        $this->_title = 'Gerenciador de Manifestos para Transporte de Resíduos';
        $this->_singular = 'MTR';
        $this->_plural = 'MTRs';
        $this->_primary = 'm.id';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;

        $this->_dono = array(
            'P' => 'Próprio',
            'T' => 'Terceiros'
        );
        $this->_certificado = array(
            'N' => 'Não',
            'S' => 'Sim'
        );

        $this->_residuos = array(
            'domestico' => array(
                'nome' => 'Resíduo Doméstico',
                'fonte' => 'Fossa Séptica',
                'descricao' => 'Substância Infectante que afeta seres humanos - Efluente Doméstico',
                'estado' => 'L',
                'classificacao' => 'I',
                'codigo' => 'A018.1',
                'unidade' => 'm³',
                'onu' => '2814',
            ),
            'industrial' => array(
                'nome' => 'Resíduo Industrial',
                'fonte' => 'Processo Produtivo',
                'descricao' => 'Substância contaminada que causa dano ao meio ambiente - Efluente Industrial',
                'estado' => 'L',
                'classificacao' => 'I',
                'codigo' => 'X0100',
                'unidade' => 'm³',
                'onu' => '3082',
            ),
        );

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'mtrs'), array('*'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id', 'sequencial'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->joinLeft(array('c' => 'certificados'), 'c.mtr_id = m.id', array('certificado_id' => 'id', 'sequencialc' => 'sequencial'));
    }

    public function buscaDadosImpressao($id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'mtrs'), array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array(''))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('gerador' => 'razao_social', 'gerador_lo' => 'numero_fepan', 'gerador_cnpj' => 'documento', 'gerador_responsavel' => 'contato', 'gerador_email' => 'email'))
                ->joinInner(array('t' => 'transportadores'), 't.id = os.transportador_id', array('transportador' => 'razao_social', 'transportador_endereco' => 'CONCAT(t.endereco,", ", t.numero)', 'transportador_fone' => 'telefone', 'transportador_lo' => 'lo', 'transportador_cnpj' => 'documento', 'transportador_cep' => 'cep'))
                ->joinInner(array('mu' => 'municipios'), 'mu.id = t.municipio_id', array('transportador_municipio' => 'nome'))
                ->joinInner(array('es' => 'estados'), 'es.id = t.estado_id', array('transportador_estado' => 'uf'))
                ->joinLeft(array('ce' => 'clientes_enderecos'), 'cl.id = ce.cliente_id', array('gerador_endereco' => 'CONCAT(ce.endereco,", ", ce.numero)', 'gerador_cep' => 'cep'))
                ->joinInner(array('muc' => 'municipios'), 'muc.id = ce.municipio_id', array('gerador_municipio' => 'nome'))
                ->joinLeft(array('ct' => 'clientes_telefones'), 'cl.id = ct.cliente_id', array('gerador_telefone' => 'telefone'))
                ->where('m.id = ?', $id);
        $itens = $consulta->query()->fetch();
        return $itens;
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'codigo_certificado' => 'Certificado',
            'mtr' => 'MTR',
            'codigo_ordem_servico' => 'Ordem de Serviço',
            'cliente' => 'Cliente',
            'dono' => 'Dono',
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'certificado' => 'asc',
            'certificado_id' => 'asc'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'o.id' => 'text',
            'cl.razao_social' => 'text',
            'dono' => 'getKey',
            'mtr' => 'text',
        );
    }

    public function adjustToView(array $data) {
        $data['codigo_certificado'] = '';
        if ($data['certificado_id']):
            $data['codigo_certificado'] = $data['orcamento_id'] . '.' . $data['sequencialc'];
        endif;
        if ($data['certificado'] == 'S' && !$data['certificado_id']) :
            $data['class'] = 'atrasada';
            $data['codigo_certificado'] = 'Gere o Certificado';
        endif;
        $data['codigo_ordem_servico'] = $data['orcamento_id'] . '.' . $data['sequencial'];
        return parent::adjustToView($data);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'ordem_servico_id' => array(
                'type' => 'Hidden'
            ),
            'mtr' => array(
                'type' => 'Text',
                'label' => 'Nº do MTR',
                'required' => true
            ),
            'terceiro' => array(
                'type' => 'Text',
                'label' => 'Nome do Terceiro',
            ),
            'dono' => array(
                'type' => 'Select',
                'label' => 'MTR Gerado',
                'required' => 'true',
                'options' => $this->listOptions('dono')
            ),
            'certificado' => array(
                'type' => 'Select',
                'label' => 'MTR precisa gerar certificado?',
                'required' => 'true',
                'options' => $this->listOptions('certificado')
            ),
            'endereco_id' => array(
                'type' => 'Select',
                'required' => true,
                'label' => 'Endereço',
                'options' => ClientesEnderecos_Model::fetchPair(),
            ),
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'dono' => 'getOption',
            'certificado' => 'getOption',
        );
    }

    public function buscarPorOrdemServico($ordem_servico_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'mtrs'), array('id', 'mtr', 'ordem_servico_id', 'dono', 'terceiro', 'certificado'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id'))
                ->joinLeft(array('c' => 'certificados'), 'c.mtr_id = m.id', array('certificado_id' => 'id', 'sequencialc' => 'sequencial'))
                ->where('m.ordem_servico_id = ?', $ordem_servico_id);
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

}
