<?php

class EnderecosCategorias_Db extends Erp_Db_Table {

    protected $_name = 'enderecos_categorias';
    protected $_dependenceTables = array('ClientesEnderecos_Db');

    public function verifyToDel($id) {
        $query = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('ec' => 'enderecos_categorias'), array(''))
                ->joinLeft(array('ce' => 'clientes_enderecos'), 'ec.id = ce.categoria_id', array('childs' => 'COUNT(ce.id)'))
                ->group('ec.id')
                ->where('ec.id = ?', $id);
        $item = $query->query()->fetch();
        if ($item['childs'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}