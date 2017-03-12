<?php

class ModulosCategorias_DB extends Erp_Db_Table {

    protected $_name = 'modulos_categorias';
    protected $_dependenceTables = array('Modulos_Db');

    public function verifyToDel($id) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('mc' => 'modulos_categorias'), array(''))
                ->joinLeft(array('m' => 'modulos'), 'mc.id = m.categoria_id', array('modulos' => 'COUNT(m.id)'))
                ->group('mc.id')
                ->where('mc.id = ? ', $id);
        $item = $sql->query()->fetch();
        if ($item['modulos'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}