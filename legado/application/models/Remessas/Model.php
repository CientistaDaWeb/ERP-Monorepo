<?php

class Remessas_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Remessas_Db();
        $this->_title = 'Gerenciador de Remessas Itaú';
        $this->_singular = 'Remessa';
        $this->_plural = 'Remessas';
        $this->_primary = 'r.id';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;


        parent::__construct();
        parent::turningFemale();
    }

    public function adjustToView(array $data) {
        $data['btImprimir'] = '<a target="_blank" href="/erp/Boleto-Itau/remessa/'.  base64_encode($data['id']).'">Imprimir Boletos</a>';
        return parent::adjustToView($data);
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data_emissao' => 'Data de Emissão',
            'banco' => 'Caixa',
            'empresa' => 'Caixa',
            'titulos' => 'Títulos',
            'btImprimir' => 'Imprimir'
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'r.data_emissao' => 'desc'
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_emissao' => 'date'
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'b.banco' => 'text',
            'cr.data_recebimento' => 'date',
            'e.razao_social' => 'text'
        );
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('r' => 'remessas'), array('*'))
                ->joinInner(array('b' => 'bancos'), 'b.id = r.banco_id', array('banco'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('cr' => 'contas_receber'), 'r.id = cr.remessa_id', array('titulos' => 'COUNT(cr.id)'))
                ->group('r.id');
    }
/*
    public function find($id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('r' => 'remessas'), array('id', 'arquivo', 'data_emissao'))
                ->joinInner(array('b' => 'bancos'), 'b.id = r.banco_id', array('banco'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('cr' => 'contas_receber'), 'r.id = cr.remessa_id', array('titulos' => 'COUNT(cr.id)'))
                ->where('r.id = ?', $id)
                ->group('r.id');
        $item = $consulta->query()->fetch();
        return $item;
    }
 */

    public function buscaSequencial() {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('r' => 'remessas'), array('total' => 'COUNT(id)'))
                ->where('r.data_emissao = ?', date('Y-m-d'));
        $item = $consulta->query()->fetch();

        $alfabeto = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z');

        return $alfabeto[$item['total']];
    }

}