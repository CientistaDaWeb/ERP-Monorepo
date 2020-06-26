<?php

class WS_Db_Table extends Zend_Db_Table_Abstract {

    public function insere($data, $acao, $tableName) {
        $data['id'] = null;
        $data['created'] = date('Y-m-d H:i:s');

        $id = parent::insert($data);
        if ($id) {
            $data['id'] = $id;
        }

        $log = new WS_LogsAlteracoes_Model();
        $log->log($this->usuario->id, $acao, $data, $tableName, 'I');

        return $id;
    }

    public function atualiza($data, $acao, $tableName) {
        if (!empty($data['id'])):
            $log = new WS_LogsAlteracoes_Model();
            $log->log($this->usuario->id, $acao, $data, $tableName, 'U');

            $where = $this->getAdapter()->quoteInto('id = ?', $data['id']);
            return parent::update($data, $where);
        endif;
    }

    public function deleta($ids, $acao, $request, $tableName) {
        if (is_array($ids)):
            foreach ($ids AS $key => $id):
                if ($this->verifyToDel($id)):
                    $request['id'] = $id;
                    $log = new WS_LogsAlteracoes_Model();
                    $log->log($this->usuario->id, $acao, $request, $tableName, 'D');

                    $where = $this->getAdapter()->quoteInto('id = ?', $id);
                    parent::delete($where);
                else:
                    return false;
                endif;
            endforeach;
            return true;
        else:
            if ($this->verifyToDel($ids)):
                $request['id'] = $ids;
                $log = new WS_LogsAlteracoes_Model();
                $log->log($this->usuario->id, $acao, $request, $tableName, 'D');

                $where = $this->getAdapter()->quoteInto('id = ?', $ids);
                return parent::delete($where);
            else:
                return false;
            endif;
        endif;
    }

    public function getTableName() {
        return $this->_name;
    }

    public function verifyToDel($id) {
        return true;
    }

}