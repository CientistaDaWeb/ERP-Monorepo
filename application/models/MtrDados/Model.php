<?php

class MtrDados_Model extends WS_Model {

    public function __construct() {
        $this->_db = new MtrDados_Db();
        $this->_title = 'Gerenciador de Dados do Manifestos para Transporte de Resíduos';
        $this->_singular = 'Dados de MTR';
        $this->_plural = 'Dados de MTRs';
        $this->_primary = 'md.id';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;

        parent::__construct();
    }

    public function buscaPorMtr($mtr_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'mtrs'), array(''))
                ->joinInner(array('md' => 'mtr_dados'), 'm.id = md.mtr_id', array('*'))
                ->where('m.id = ?', $mtr_id);
        $itens = $consulta->query()->fetch();
        return $itens;
    }

}
