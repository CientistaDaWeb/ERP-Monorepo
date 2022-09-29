<?php

class WS_LogsAcessos_Db extends Zend_Db_Table_Abstract {

    protected $_name = 'logs_acessos';
    protected $_referenceMap = array(
        'Usuario' => array(
            'refTableClass' => 'Usuarios_Db',
            'refColumns' => 'id',
            'columns' => array('usuario_id')
        )
    );
}

