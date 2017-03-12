<?php

class TemplatesCategorias_Db extends Erp_Db_Table {

    protected $_name = 'templates_categorias';

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('tc' => 'templates_categorias'), array(''))
                ->joinLeft(array('t' => 'templates'), 'tc.id = t.categoria_id', array('childs' => 'COUNT(t.id)'))
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