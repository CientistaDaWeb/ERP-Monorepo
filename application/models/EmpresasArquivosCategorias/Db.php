<?php

class EmpresasArquivosCategorias_DB extends Erp_Db_Table {

    protected $_name = 'empresas_arquivos_categorias';

    public function verifyToDel($id) {
        $sql = $this->select()
                ->setIntegrityCheck(false)
                ->from(array('cac' => 'empresas_arquivos_categorias'), array(''))
                ->joinLeft(array('ca' => 'empresas_arquivos'), 'cac.id = ca.categoria_id', array('arquivos' => 'COUNT(ca.id)'))
                ->group('cac.id')
                ->where('cac.id = ? ', $id);
        $item = $sql->query()->fetch();
        if ($item['arquivos'] > 0):
            return false;
        else:
            return true;
        endif;
    }

}