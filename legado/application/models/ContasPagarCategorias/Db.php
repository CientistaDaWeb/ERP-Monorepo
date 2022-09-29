<?php

class ContasPagarCategorias_DB extends Erp_Db_Table {

    protected $_name = 'contas_pagar_categorias';
    protected $_dependenceTables = array('ContasPagar_DB');

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cpc' => 'contas_pagar_categorias'), array(''))
                ->joinLeft(array('cp' => 'contas_pagar'), 'cpc.id = cp.categoria_id', array('childs' => 'COUNT(cp.id)'))
                ->group('cpc.id')
                ->where('cpc.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }
}