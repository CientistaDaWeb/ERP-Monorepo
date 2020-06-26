<?php

class CtesAcqualife_Db extends Erp_Db_Table {

    protected $_name = 'ctes_acqualife';

    public function verifyToDel($id) {
        $ContasReceberModel = new ContasReceber_Model();
        $data['cte_id'] = NULL;
        $where = $ContasReceberModel->_db->getAdapter()->quoteInto('cte_id = ?', $id);
        $ContasReceberModel->_db->update($data, $where);
        parent::verifyToDel($id);
    }

}
