<?php

class Fornecedores_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Fornecedores_Db();
        $this->_pair = 'razao_social';
        $this->_title = 'Gerenciador de Fornecedores';
        $this->_singular = 'Fornecedor';
        $this->_plural = 'Fornecedores';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'f.id';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('f' => 'fornecedores'), array('id', 'razao_social'))
                ->order('razao_social');
        return $db->fetchPairs($sql);
    }

    public static function fetchPairCaminhao() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from(array('f' => 'fornecedores'), array('id', 'razao_social'))
                ->where('f.categoria_id IN (?)', array(20, 17))
                ->order('razao_social');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('f' => 'fornecedores'), array('*'))
                ->joinInner(array('fc' => 'fornecedores_categorias'), 'fc.id = f.categoria_id', array('categoria'))
                ->joinLeft(array('cp' => 'contas_pagar'), 'f.id = cp.fornecedor_id', array('contas_pagar' => 'COUNT(cp.id)'))
                ->group('f.id');
    }

    public function adjustToView(array $data) {
        $data['telefones'] = '<a href="tel:+55' . WS_Text::onlyNumber($data['telefone']) . '">' . str_replace('.', '-', $data['telefone']) . '</a>';
        if (!empty($data['telefone2'])):
            $data['telefones'] .= ' | <a href="tel:+55' . WS_Text::onlyNumber($data['telefone2']) . '">' . str_replace('.', '-', $data['telefone2']) . '</a>';
        endif;
        if (!empty($data['telefone3'])):
            $data['telefones'] .= ' | <a href="tel:+55' . WS_Text::onlyNumber($data['telefone3']) . '">' . str_replace('.', '-', $data['telefone3']) . '</a>';
        endif;
        return $data;
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'f.razao_social' => 'asc',
            'fc.categoria' => 'asc',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'f.razao_social' => 'text',
            'f.nome_fantasia' => 'text',
            'fc.categoria' => 'text',
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'categoria' => 'Categoria',
            'razao_social' => 'Fornecedor',
            'contas_pagar' => 'Nº Contas Pagar',
            'telefones' => 'Telefones'
        );
    }

}
