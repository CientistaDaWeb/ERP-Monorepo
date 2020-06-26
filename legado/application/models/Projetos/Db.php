<?php

class Projetos_Db extends Erp_Db_Table {

    protected $_name = 'projetos';

    public function init() {
        $this->_delPermission = true;
        parent::init();
    }

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('p' => 'projetos'), array(''))
                ->joinLeft(array('pa' => 'projetos_atividades'), 'p.id = pa.projeto_id', array('childs' => 'COUNT(pa.id)'))
                ->group('p.id')
                ->where('p.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}
