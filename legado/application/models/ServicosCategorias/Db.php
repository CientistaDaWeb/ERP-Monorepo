<?php

class ServicosCategorias_Db extends Erp_Db_Table {

    protected $_name = 'servicos_categorias';
    protected $_dependenceTables = array('Servicos');

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('sc' => 'servicos_categorias'), array(''))
                ->joinLeft(array('s' => 'servicos'), 'sc.id = s.categoria_id', array('childs' => 'COUNT(s.id)'))
                ->group('sc.id')
                ->where('sc.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }
}