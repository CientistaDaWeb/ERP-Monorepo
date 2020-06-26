<?php

class ClientesCategorias_DB extends Erp_Db_Table {

    protected $_name = 'clientes_categorias';
    protected $_dependenceTables = array('Clientes_Db');

    public function verifyToDel($id) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cc' => 'clientes_categorias'), array(''))
                ->joinLeft(array('c' => 'clientes'), 'cc.id = c.categoria_id', array('clientes' => 'COUNT(c.id)'))
                ->group('cc.id')
                ->where('cc.id = ? ', $id);
        $item = $sql->query()->fetch();
        if ($item['clientes'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}