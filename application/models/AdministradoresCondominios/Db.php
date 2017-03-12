<?php

class AdministradoresCondominios_Db extends Erp_Db_Table {

    protected $_name = 'administradores_condominios';
    protected $_dependenceTables = array('Clientes_Db');

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('ac' => 'administradores_condominios'), array(''))
                ->joinLeft(array('c' => 'clientes'), 'ac.id = c.administrador_id', array('clientes' => 'COUNT(c.id)'))
                ->group('ac.id')
                ->where('ac.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['clientes'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}
