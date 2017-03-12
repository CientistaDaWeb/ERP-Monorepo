<?php

class UsuariosCompromissos_Db extends Erp_Db_Table {

    protected $_name = 'usuarios_compromissos';
    protected $_referenceMap = array(
        'Usuario' => array(
            'refTableClass' => 'Usuarios',
            'refColumns' => array('id'),
            'columns' => array('usuario_id')
        )
    );

}
