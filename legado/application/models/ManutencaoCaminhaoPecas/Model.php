<?php

class ManutencaoCaminhaoPecas_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ManutencaoCaminhaoPecas_Db();
        $this->_title = 'Gerenciador de Peças em Manutenção de Caminhões';
        $this->_singular = 'Peça em Manutenção de Caminhão';
        $this->_plural = 'Peças em Manutenção de Caminhão';

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('mp' => 'manutencoes_pecas'), array('*'))
                ->joinInner(array('m' => 'manutencoes'), 'm.id = mp.manutencao_id', array(''))
                ->joinInner(array('p' => 'pecas'), 'p.id = mp.peca_id', array('peca' => 'nome'))
        ;
    }

    public function limpaManutencao($manutencao_id) {
        $where = $this->_db->getAdapter()->quoteInto('manutencao_id = ?', $manutencao_id);
        $this->_db->delete($where);
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'valor' => 'money'
        );
    }

    public function addPeca($data) {
        $this->_db->insere($data, $this->getOption('actions', 'add'), $this->_db->getTableName());
    }

    public function getByManutencao($manutencao_id) {
        $sql = clone($this->_basicSearch);
        $sql->where('m.id = ?', $manutencao_id);
        return $sql->query()->fetchAll();
    }

}
