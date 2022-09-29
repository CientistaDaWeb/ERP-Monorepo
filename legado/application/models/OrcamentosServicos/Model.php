<?php

class OrcamentosServicos_Model extends WS_Model {

    public function __construct() {
        $this->_db = new OrcamentosServicos_Db();
        $this->_title = 'Gerenciador de Serviços em Orçamentos';
        $this->_singular = 'Serviço em Orçamento';
        $this->_plural = 'Serviços em Orçamentos';

        parent::__construct();
    }

    public function limpaServicos($orcamento_id) {
        $where = $this->_db->getAdapter()->quoteInto('orcamento_id = ?', $orcamento_id);
        $this->_db->delete($where);
    }

    public function addServico($data) {
        $this->_db->insere($data, $this->getOption('actions', 'add'), $this->_db->getTableName());
    }

}
