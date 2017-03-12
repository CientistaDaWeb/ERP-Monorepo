<?php

class Erp_Db_Table extends WS_Db_Table {

    protected $_delPermission;

    public function init() {
        $auth = new WS_Auth('erp');
        if ($auth->hasIdentity()) :
            $usuario = $auth->getIdentity();
            $this->usuario = $usuario;
            parent::init();
        else:
            return false;
        endif;
    }

    public function deleta($ids, $acao, $request, $tableName) {
        if (!empty($this->_delPermission)):
            parent::deleta($ids, $acao, $request, $tableName);
        else:
            if ($this->usuario->papel == 'A'):
                parent::deleta($ids, $acao, $request, $tableName);
            else:
                return false;
            endif;
        endif;
    }

}