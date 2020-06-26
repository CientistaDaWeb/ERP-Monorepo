<?php

class PesquisaSatisfacao_Model extends WS_Model {

    protected $_satisfacao, $_recomendaria;

    public function __construct() {
        $this->_db = new PesquisaSatisfacao_Db();
        $this->_title = 'Gerenciador de Pesquisa de Satisfação';
        $this->_singular = 'Pesquisa de Satisfação';
        $this->_plural = 'Pesquisas de Satisfação';
        $this->_layoutList = 'basic';
        $this->_primary = 'ps.id';

        $this->_satisfacao = $this->_atendimento_telefone = $this->_atendimento_coleta = $this->_documentacao = $this->_atendimento_servico = array(
            'MS' => 'Muito Satisfeito',
            'S' => 'Satisfeito',
            'PS' => 'Pouco Satisfeito',
            'I' => 'Insatisfeito',
        );

        $this->_recomendaria = array(
            'S' => 'Sim',
            'N' => 'Não',
        );

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ps' => 'pesquisa_satisfacao'), array('*'))
                ->joinInner(array('c' => 'certificados'), 'c.id = ps.certificado_id', array('sequencial'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array('mtr'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->group('ps.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'ps.data' => 'date',
            'cl.razao_social' => 'text',
            'o.id' => 'text',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'certificado_id' => array(
                'type' => 'Hidden'
            ),
            'data' => array(
                'type' => 'Hidden'
            ),
            'atendimento_telefone' => array(
                'label' => 'Atendimento ao telefone, como foi a:',
                'description' => 'Cordialidade, clareza nas instruções,disponibilidade e agilidade dos atendentes',
                'type' => 'Select',
                'option' => array('' => 'Selecione ...'),
                'options' => $this->_satisfacao,
                'required' => true,
            ),
            'atendimento_coleta' => array(
                'label' => 'Atendimento durante a coleta, como foi nos quesitos:',
                'description' => 'Habilidade do coletor; Confiabilidade; limpeza e organização; uso de Epis; instruções fornecidas ao cliente',
                'type' => 'Select',
                'option' => array('' => 'Selecione ...'),
                'options' => $this->_satisfacao,
                'required' => true,
            ),
            'documentacao' => array(
                'label' => 'Documentações, como avalia as documentações fornecidas:',
                'description' => 'MTRs; certificados; relatórios de coleta; boletos,  licenças',
                'type' => 'Select',
                'option' => array('' => 'Selecione ...'),
                'options' => $this->_satisfacao,
                'required' => true,
            ),
            'atendimento_servico' => array(
                'label' => 'Atendimento pós prestação de serviço, como avalia os quesitos:',
                'description' => 'Retorno sobre a coleta; esclarecimentos fornecidos; conferências; controle de periodicidade da coleta',
                'type' => 'Select',
                'option' => array('' => 'Selecione ...'),
                'options' => $this->_satisfacao,
                'required' => true,
            ),
            'recomendaria' => array(
                'label' => 'Você recomendaria a Acquasana Transportes de efluentes?',
                'type' => 'Select',
                'option' => array('' => 'Selecione ...'),
                'options' => $this->_recomendaria,
                'required' => true,
            ),
            'observacoes' => array(
                'label' => 'Abaixo escreva suas sugestões ou observações sobre nossa empresa. Sinta-se bem à vontade para expor sua opinião, a Acquasana agradece sua contribuição.',
                'type' => 'Textarea',
            ),
        );
    }

    public function adjustToDb(array $data) {
        $data['data'] = date('Y-m-d');
        parent::adjustToDb($data);
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'atendimento_telefone' => 'getOption',
            'atendimento_coleta' => 'getOption',
            'documentacao' => 'getOption',
            'atendimento_servico' => 'getOption',
            'recomendaria' => 'getOption',
        );
        parent::setAdjustFields();
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data' => 'Data',
            'cliente' => 'Cliente',
            'codigo' => 'Certificado',
            'atendimento_telefone' => 'Telefone',
            'atendimento_coleta' => 'Coleta',
            'documentacao' => 'Documentação',
            'atendimento_servico' => 'Serviço',
            'recomendaria' => 'Recomendaria',
            'observacoes' => 'Observações',
        );
    }

    public function adjustToView(array $data) {
        $data['codigo'] = $data['orcamento_id'] . '.' . $data['sequencial'];
        return parent::adjustToView($data);
    }

    public function buscaPorCte($id) {
        $consulta = clone($this->_basicSearch);
        $consulta
                ->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
                ->joinInner(array('cr' => 'contas_receber'), 'cr.id = cros.conta_receber_id', array(''))
                ->where('cr.cte_id = ?', $id)
                ->limit(1);
        return $consulta->query()->fetch();
    }

    public function buscaPorCteAcqualife($id) {
        $consulta = clone($this->_basicSearch);
        $consulta
                ->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
                ->joinInner(array('cr' => 'contas_receber'), 'cr.id = cros.conta_receber_id', array(''))
                ->where('cr.cte_acqualife_id = ?', $id)
                ->limit(1);
        return $consulta->query()->fetch();
    }

    public function buscaCertificadoPorCte($id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('id'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array(''))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
                ->joinInner(array('cr' => 'contas_receber'), 'cr.id = cros.conta_receber_id', array(''))
                ->where('cr.cte_id = ?', $id)
                ->limit(1)
                ->group('c.id');
        return $consulta->query()->fetch();
    }

    public function buscaCertificadoPorCteAcqualife($id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('id'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array(''))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->joinInner(array('cros' => 'contas_receber_ordens_servicos'), 'os.id = cros.ordem_servico_id', array(''))
                ->joinInner(array('cr' => 'contas_receber'), 'cr.id = cros.conta_receber_id', array(''))
                ->where('cr.cte_acqualife_id = ?', $id)
                ->limit(1)
                ->group('c.id');
        return $consulta->query()->fetch();
    }

    public function relatorio($data) {
        $consulta = clone($this->_basicSearch);

        if (!empty($data['data_inicial'])):
            $consulta->where('ps.data >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('ps.data <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscaPorCertificado($id) {
        $consulta = clone($this->_basicSearch);
        $consulta->where('ps.certificado_id = ?', $id);
        return $consulta->query()->fetch();
    }

}
