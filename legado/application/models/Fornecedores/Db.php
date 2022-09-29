<?php

class Fornecedores_Db extends Erp_Db_Table {

    protected $_name = 'fornecedores';
    protected $_dependenceTables = array();
    protected $_referenceMap = array(
        'Categoria' => array(
            'refTableClass' => 'FornecedoresCategorias_Db',
            'refColumns' => array('id'),
            'columns' => array('categoria_id')
        )
    );

    public function verifyToDel($id) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('f' => 'fornecedores'), array(''))
                ->joinLeft(array('cp' => 'contas_pagar'), 'f.id = cp.fornecedor_id', array('childrens' => 'COUNT(cp.id)'))
                ->where('f.id = ?', $id)
                ->group('f.id');
        $item = $sql->query()->fetch();
        if($item['childrens'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}
