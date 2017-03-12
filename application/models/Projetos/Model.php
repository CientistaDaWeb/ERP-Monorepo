<?php

class Projetos_Model extends WS_Model {

    protected $_prioridade, $_cor;

    public function __construct() {
        $this->_db = new Projetos_Db();
        $this->_title = 'Gerenciador de Projetos';
        $this->_singular = 'Projeto';
        $this->_plural = 'Projetos';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'p.id';

        $this->_prioridade = array(
            'C' => 'Crítico',
            'U' => 'Urgente',
            'A' => 'Alta',
            'N' => 'Normal',
            'B' => 'Baixa',
            'M' => 'Mais Baixa',
        );

        $this->_cor = array(
            'C' => '#FF6666',
            'U' => '#f2ab99',
            'A' => '#FFC266',
            'N' => '#b0d295',
            'B' => '#e7e0c4',
            'M' => '#F3F3F3',
        );

        $this->_status = array(
            'I' => 'Cadastrado',
            'A' => 'Andamento',
            'C' => 'Concluído'
        );

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => 'projetos'), array('*'))
                ->joinInner(array('pc' => 'projetos_categorias'), 'pc.id = p.categoria_id', array('categoria'))
                ->joinLeft(array('c' => 'construtoras'), 'c.id = p.construtora_id', array('construtora' => 'nome'))
                ->joinLeft(array('a' => 'arquitetos'), 'a.id = p.arquiteto_id', array('arquiteto' => 'nome'))
                ->group('p.id');
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $consulta = $db->select()
                ->from('projetos', array('id', 'nome'))
                ->order('nome');
        return $db->fetchPairs($consulta);
    }

    public function adjustToView(array $data) {
        if (empty($data['arquiteto'])):
            $data['arquiteto'] = '<div class="error">Não informado!</div>';
        endif;
        if (empty($data['construtora'])):
            $data['construtora'] = '<div class="error">Não informado!</div>';
        endif;

        return parent::adjustToView($data);
    }

    public function adjustToAgenda(array $data) {
        $data['cor'] = $this->_cor[$data['prioridade']];
        return $data;
    }

    public function adjustToForm(array $data) {
        if (!empty($data['diretorio'])):
            $data['diretorio'] = str_replace('\\\\', "\\", $data['diretorio']);
        endif;
        return parent::adjustToForm($data);
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'nome' => 'asc',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'arquiteto_id' => 'int',
            'construtora_id' => 'int',
            'status' => 'getOption',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'p.nome' => 'text',
            'p.proprietario' => 'text',
            'c.nome' => 'text',
            'a.nome' => 'text',
            'p.observacoes' => 'text',
            'p.numero_protocolo' => 'text',
            'pc.categoria' => 'getOption',
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden',
            ),
            'categoria_id' => array(
                'label' => 'Categoria',
                'type' => 'Select',
                'option' => array('' => 'Selecione a categoria ...'),
                'options' => ProjetosCategorias_Model::fetchPair(),
                'required' => true,
            ),
            'numero_protocolo' => array(
                'label' => 'Número do Protocolo',
                'type' => 'Text',
                'required' => true,
            ),
            'nome' => array(
                'label' => 'Nome do Projeto',
                'type' => 'Text',
                'required' => true,
            ),
            'proprietario' => array(
                'label' => 'Proprietário',
                'type' => 'Text',
            ),
            'arquiteto_id' => array(
                'label' => 'Arquiteto',
                'type' => 'Select',
                'option' => array(' ' => 'Não informado'),
                'options' => Arquitetos_Model::fetchPair(),
            ),
            'construtora_id' => array(
                'label' => 'Construtora',
                'type' => 'Select',
                'option' => array(' ' => 'Não informado'),
                'options' => Construtoras_Model::fetchPair(),
            ),
            'endereco' => array(
                'label' => 'Endereço',
                'type' => 'Text',
                'required' => true,
            ),
            'observacoes' => array(
                'label' => 'Observações',
                'type' => 'Textarea',
                'required' => false,
            ),
            'diretorio' => array(
                'label' => 'Diretório',
                'type' => 'Text',
            ),
            'status_ppci' => array(
                'label' => 'Status do PPCI',
                'type' => 'Select',
                'options' => $this->_status,
            ),
            'status_hidro' => array(
                'label' => 'Status do Hidro',
                'type' => 'Select',
                'options' => $this->_status,
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome do Projeto',
            'numero_protocolo' => 'Protocolo',
            'proprietario' => 'Proprietário',
            'arquiteto' => 'Arquiteto',
            'construtora' => 'Construtora',
            'categoria' => 'Categoria',
//            'diretorio' => 'Diretório',
            'status' => 'Status',
        );
    }

    public function relatorio($data) {
        $sql = clone($this->_basicSearch);
        if (!empty($data['construtora_id'])):
            $sql->where('p.construtora_id = ?', $data['construtora_id']);
        endif;
        if (!empty($data['arquiteto_id'])):
            $sql->where('p.arquiteto_id = ?', $data['arquiteto_id']);
        endif;
        if (!empty($data['projeto_id'])):
            $sql->where('p.id = ?', $data['projeto_id']);
        endif;
        if (!empty($data['categoria_id'])):
            $sql->where('p.categoria_id = ?', $data['categoria_id']);
        endif;
        if (!empty($data['data_inicial'])):
            $sql->where('p.data_inicio >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $sql->where('p.data_inicio <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;
        return $sql->query()->fetchAll();
    }

    public function agenda($inicio, $fim, $usuario_id) {
        $ppci = $this->ppci_abertos($inicio, $fim, $usuario_id);
        $hidro = $this->hidro_abertos($inicio, $fim, $usuario_id);
        $retorno = array();
        foreach ($ppci AS $item):
            $item = $this->adjustToAgenda($item);
            $item['data_entrega'] = $item['data_entrega_ppci'];
            $item['nome'] = 'PPCI - ' . $item['nome'] . ' - ' . $item['andamento'];
            $retorno[] = $item;
        endforeach;
        foreach ($hidro AS $item):
            $item = $this->adjustToAgenda($item);
            $item['data_entrega'] = $item['data_entrega_hidro'];
            $item['nome'] = 'HIDRO - ' . $item['nome'] . ' - ' . $item['andamento'];
            $retorno[] = $item;
        endforeach;
        return $retorno;
    }

    public function buscaPorCategoria($categoria) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => 'projetos'), array('*'))
                ->joinInner(array('pc' => 'projetos_crm'), 'p.id = pc.projeto_id', array('data' => 'max(pc.data)'))
                ->where('p.categoria_id IN (?)', $categoria)
                ->where('p.status != ?', 'C')
                ->group('p.id')
        ;

        return $consulta->query()->fetchAll();
    }

    public function ppci_abertos($inicio = NULL, $fim = NULL, $usuario_id = NULL) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => 'projetos'), array('*'))
                ->joinInner(array('pc' => 'projetos_crm'), 'p.id = pc.projeto_id', array('data' => 'max(pc.data)'))
                ->where('p.categoria_id != ?', '1')
                ->where('p.status_ppci != ?', 'C')
                ->group('p.id');

        if (!empty($usuario_id)):
            $consulta->where('u.id = ?', $usuario_id);
        endif;
        if (!empty($inicio) && !empty($fim)):
            $consulta->where('p.data_entrega_ppci >= ?', $inicio)
                    ->where('p.data_entrega_ppci <= ?', $fim);
        endif;
        return $consulta->query()->fetchAll();
    }

    public function hidro_abertos($inicio = NULL, $fim = NULL, $usuario_id = NULL) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => 'projetos'), array('*'))
                ->joinInner(array('pc' => 'projetos_crm'), 'p.id = pc.projeto_id', array('data' => 'max(pc.data)'))
                ->where('p.categoria_id != ?', '2')
                ->where('p.status_hidro != ?', 'C')
                ->group('p.id');

        if (!empty($usuario_id)):
            $consulta->where('u.id = ?', $usuario_id);
        endif;
        if (!empty($inicio) && !empty($fim)):
            $consulta->where('p.data_entrega_hidro >= ?', $inicio)
                    ->where('p.data_entrega_hidro <= ?', $fim);
        endif;
        return $consulta->query()->fetchAll();
    }

}
