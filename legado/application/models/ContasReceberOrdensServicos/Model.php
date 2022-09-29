<?php

class ContasReceberOrdensServicos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ContasReceberOrdensServicos_Db();
        $this->_title = 'Gerenciador de Ordens de Serviço na Conta a Receber';
        $this->_singular = 'Ordem de Serviço na Conta a Receber';
        $this->_plural = 'Ordens de Serviço na Conta a Receber';

        parent::__construct();
    }

    public function limpaConta($conta_id) {
        $where = $this->_db->getAdapter()->quoteInto('conta_receber_id = ?', $conta_id);
        $this->_db->delete($where);
    }

    public function addConta($data) {
        $this->_db->insere($data, $this->getOption('actions', 'add'), $this->_db->getTableName());
    }

}
