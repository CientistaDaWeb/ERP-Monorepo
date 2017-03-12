<?php

class ProjetosCategorias_DB extends Erp_Db_Table {

    protected $_name = 'projetos_categorias';
    protected $_dependenceTables = array('Projetos_Db');

    public function verifyToDel($id) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('pc' => 'projetos_categorias'), array(''))
                ->joinLeft(array('p' => 'projetos'), 'pc.id = p.categoria_id', array('items' => 'COUNT(p.id)'))
                ->group('pc.id')
                ->where('pc.id = ? ', $id);
        $item = $sql->query()->fetch();
        if ($item['items'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}