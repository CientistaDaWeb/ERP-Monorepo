<?php

class FornecedoresCategorias_Db extends Erp_Db_Table {

    protected $_name = 'fornecedores_categorias';
    protected $_dependenceTables = array('Fornecedores');

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('fc' => 'fornecedores_categorias'), array(''))
                ->joinLeft(array('f' => 'fornecedores'), 'fc.id = f.categoria_id', array('childs' => 'COUNT(f.id)'))
                ->group('fc.id')
                ->where('fc.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}