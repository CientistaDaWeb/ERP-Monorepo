<?php

class Empresas_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Empresas_Db();
        $this->_title = 'Gerenciador de Empresas';
        $this->_singular = 'Empresa';
        $this->_plural = 'Empresas';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'e.id';

        parent::__construct();
        parent::turningFemale();
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'razao_social' => 'Empresa',
            'documento' => 'CNPJ'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'razao_social' => 'text',
            'documento' => 'text'
        );
    }

    public function adjustToDb(array $data) {
        if (empty($data['logomarca'])):
            unset($data['logomarca']);
        endif;
        return parent::adjustToDb($data);
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('e' => 'empresas'), array('*'))
                ->joinInner(array('m' => 'municipios'), 'm.id = e.municipio_id', array('municipio' => 'nome', 'codigo_municipio' => 'codigo'))
                ->joinInner(array('es' => 'estados'), 'es.id = e.estado_id', array('uf'));
    }

    public static function fetchPair() {
        $db = WS_Model::getDefaultAdapter();
        $consulta = $db->select()
                ->from('empresas', array('id', 'razao_social'))
                ->order('razao_social');
        return $db->fetchPairs($consulta);
    }

    public function buscarDadosPorFormaPagamento($forma_pagamento_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('fp' => 'formas_pagamento'), array('*'))
                ->joinInner(array('b' => 'bancos'), 'b.id = fp.banco_id', array('*'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('*'))
                ->where('fp.id = ?', $forma_pagamento_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function buscaParaCte($empresa_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('e' => 'empresas'), array('*'))
                ->joinInner(array('m' => 'municipios'), 'm.id = e.municipio_id', array('municipio' => 'nome', 'codigo_municipio' => 'codigo'))
                ->joinInner(array('es' => 'estados'), 'es.id = m.estado_id', array('uf', 'estado', 'codigo_uf' => 'codigo'))
                ->where('e.id = ?', $empresa_id)
        ;
        $item = $consulta->query()->fetch();
        return $item;
    }

}