<?php

class ProjetosAtividades_Model extends WS_Model {

    protected $_status, $_usuario_id;

    public function __construct() {
        $this->_db = new ProjetosAtividades_Db();
        $this->_title = 'Gerenciador de Atividades de Projetos';
        $this->_singular = 'Atividade de Projeto';
        $this->_plural = 'Atividades de Projetos';
        $this->_primary = 'pa.id';
        $this->_layoutList = 'basic';

        $this->_status = array(
            'P' => 'Pendente',
            'C' => 'Concluido',
        );

        $auth = new WS_Auth('erp');
        if ($auth->hasIdentity()):
            $usuario = $auth->getIdentity();
            $this->_usuario_id = $usuario->id;
        endif;

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pa' => 'projetos_atividades'), array('*'))
                ->joinInner(array('p' => 'projetos'), 'p.id = pa.projeto_id', array(''))
                ->joinLeft(array('pat' => 'projetos_atividades_tempo'), 'pa.id = pat.projeto_atividade_id', array('tempo' => 'SUM(minutos)'))
                ->group('pa.id')
        ;
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'projeto_id' => array(
                'type' => 'Hidden'
            ),
            'categoria_id' => array(
                'type' => 'Select',
                'label' => 'Categoria',
                'required' => true,
                'options' => ProjetosCategorias_Model::fetchPair()
            ),
            'nome' => array(
                'type' => 'Text',
                'label' => 'Nome',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'Textarea',
                'label' => 'Descrição',
                'required' => true
            ),
            'pontos' => array(
                'type' => 'Number',
                'label' => 'Pontos',
                'required' => true
            ),
            'status' => array(
                'type' => 'Select',
                'label' => 'Status',
                'required' => true,
                'options' => $this->_status
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'pontos' => 'Pontos',
            'status' => 'Status',
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'status' => 'getOption',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'pa.nome' => 'nome',
            'pa.descricao' => 'descricao',
        );
    }

    public function getByProject($projeto_id) {
        $sql = clone $this->_basicSearch;
        $sql->where('p.id = ?', $projeto_id)
                ->joinInner(array('pc' => 'projetos_categorias'), 'pc.id = pa.categoria_id', array('categoria'))
                ->group('pa.id');
        return $sql->query()->fetchAll();
    }

    public function getPoints($projeto_id, $categorias) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pa' => 'projetos_atividades'), array('pontuacao' => 'SUM(pontos)'))
                ->joinInner(array('p' => 'projetos'), 'p.id = pa.projeto_id', array(''))
                ->where('p.id = ?', $projeto_id)
                ->where('pa.categoria_id IN(?)', $categorias)
                ->limit(1);
        return $sql->query()->fetch();
    }

    public function getCompletePoints($projeto_id, $categorias) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pa' => 'projetos_atividades'), array('pontuacao' => 'SUM(pontos)'))
                ->joinInner(array('p' => 'projetos'), 'p.id = pa.projeto_id', array(''))
                ->where('pa.status = ?', 'C')
                ->where('p.id = ?', $projeto_id)
                ->where('pa.categoria_id IN(?)', $categorias)
                ->limit(1);
        return $sql->query()->fetch();
    }

    public function getUnfinishedByProject($projeto_id = NULL) {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from('projetos_atividades', array('id', 'nome'))
                ->order('nome')
                ->where('status = "P"');
        if (!empty($projeto_id)):
            $sql->where('projeto_id = ?', $projeto_id);
            return $db->fetchPairs($sql);
        else:
            return false;
        endif;
    }

    public function relatorio($projeto_id, $data) {
        $sql = clone($this->_basicSearch);
        $sql->where('p.id IN (?)', $projeto_id);
        if (!empty($data['data_inicial'])):
            $sql->where('pa.updated >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $sql->where('pa.updated <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        return $sql->query()->fetchAll();
    }

    public function ajusta() {
        $atividades = $this->listagem();
        foreach ($atividades AS $item):
            $TemplatesModel = new Templates_Model();
            $template = $TemplatesModel->findByDescription($item['descricao']);
            if (!empty($template)):
                $where = $this->_db->getAdapter()->quoteInto('id = ?', $item['id']);
                $data['categoria_id'] = $template['categoria_id'];
                $this->_db->update($data, $where);
            endif;
        endforeach;
    }

    public function adjustToView(array $data) {
        $ProjetosAtividadesTempoModel = new ProjetosAtividadesTempo_Model();
        $data['iniciado'] = $ProjetosAtividadesTempoModel->getStatus($data['id'], $this->_usuario_id);
        return parent::adjustToView($data);
    }

}
