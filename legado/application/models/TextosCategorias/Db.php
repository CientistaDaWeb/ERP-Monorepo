<?php

class TextosCategorias_Db extends Erp_Db_Table {

    protected $_name = 'textos_categorias';
    protected $_dependenceTables = array('Textos');

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('tc' => 'textos_categorias'), array(''))
                ->joinLeft(array('t' => 'textos'), 'tc.id = t.categoria_id', array('childs' => 'COUNT(t.id)'))
                ->group('tc.id')
                ->where('tc.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}