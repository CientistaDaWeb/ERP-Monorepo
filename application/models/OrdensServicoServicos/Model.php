<?php

class OrdensServicoServicos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new OrdensServicoServicos_Db();
        $this->_title = 'Gerenciador de Serviços em Ordens de Serviço';
        $this->_singular = 'Serviço em Ordens de Serviço';
        $this->_plural = 'Serviços em Ordens de Serviço';

        parent::__construct();
    }

    public function limpaServicos($ordem_servico_id) {
        $where = $this->_db->getAdapter()->quoteInto('ordem_servico_id = ?', $ordem_servico_id);
        $this->_db->delete($where);
    }

    public function addServico($data) {
        $this->_db->insere($data, $this->getOption('actions', 'add'), $this->_db->getTableName());
    }

}
