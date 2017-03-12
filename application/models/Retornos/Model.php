<?php

class Retornos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Retornos_Db();
        $this->_title = 'Gerenciador de Retornos';
        $this->_singular = 'Retorno';
        $this->_plural = 'Retornos';
        $this->_primary = 'r.id';
        $this->_layoutList = 'basic';

        parent::__construct();
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_recebimento' => 'date'
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'r.data_recebimento' => 'desc'
        );
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('r' => 'retornos'), array('*'))
                ->joinInner(array('b' => 'bancos'), 'b.id = r.banco_id', array('banco'))
                ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa' => 'razao_social'))
                ->joinInner(array('cr' => 'contas_receber'), 'r.id = cr.retorno_id', array('titulos' => 'COUNT(cr.id)'))
                ->group('r.id');
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data_recebimento' => 'Data de Recebimento',
            'empresa' => 'Empresa',
            'titulos' => 'Titulos'
        );
    }

    /*
      public function find($id) {
      $consulta = $this->_db->select()
      ->setIntegrityCheck(false)
      ->from(array('r' => 'retornos'), array('id', 'arquivo', 'data_recebimento'))
      ->joinInner(array('b' => 'bancos'), 'b.id = r.banco_id', array('banco'))
      ->joinInner(array('e' => 'empresas'), 'e.id = b.empresa_id', array('empresa' => 'razao_social'))
      ->joinInner(array('cr' => 'contas_receber'), 'r.id = cr.retorno_id', array('titulos' => 'COUNT(cr.id)'))
      ->where('r.id = ?', $id)
      ->group('r.id');
      $item = $consulta->query()->fetch();
      return $item;
      }
     */
}