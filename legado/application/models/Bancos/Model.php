<?php

class Bancos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Bancos_Db();
        $this->_pair = 'banco';
        $this->_title = 'Gerenciador de Bancos';
        $this->_singular = 'Banco';
        $this->_plural = 'Bancos';
        $this->_primary = 'b.id';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $sql = $db->select()
                ->from('bancos', array('id', 'banco'))
                ->order('banco');
        return $db->fetchPairs($sql);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('b' => 'bancos'), array('*'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa' => 'razao_social'));
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'b.banco' => 'text',
            'b.agencia' => 'text',
            'e.empresa' => 'text',
            'b.conta_corrente' => 'text'
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
                'option' => array('' => 'Selecione a Empresa...'),
                'options' => Empresas_Model::fetchPair(),
                'required' => true
            ),
            'banco' => array(
                'label' => 'Nome do Caixa',
                'type' => 'Text',
                'required' => true
            ),
            'agencia' => array(
                'label' => 'Agência',
                'type' => 'Text',
                'required' => true
            ),
            'conta_corrente' => array(
                'label' => 'Conta Corrente',
                'type' => 'Text',
                'required' => true
            ),
            'carteira' => array(
                'label' => 'Carteira',
                'type' => 'Number',
                'required' => true
            )
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'empresa' => 'Empresa',
            'banco' => 'Banco',
            'agencia' => 'Agência',
            'conta_corrente' => 'Conta Corrente'
        );
    }

    public function buscarPorConta($agencia, $conta_corrente) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('b' => 'bancos'), array('*'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa_id' => 'id'))
                ->where('b.agencia = ?', $agencia)
                ->where('b.conta_corrente = ?', $conta_corrente);
        $item = $consulta->query()->fetch();
        return $item;
    }

}
