<?php

class Transportadores_Db extends Erp_Db_Table {

    protected $_name = 'transportadores';
    protected $_dependenceTables = array();

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('t' => 'transportadores'), array('*'))
                ->joinLeft(array('os' => 'ordens_servico'), 't.id = os.transportador_id', array('os' => 'COUNT(os.id)'))
                ->group('t.id')
                ->where('t.id = ?', $id);
        $item = $query->query()->fetch();
        if($item['os'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}
