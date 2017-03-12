<?php

class AclAcessoSistema_Db extends Erp_Db_Table {

    protected $_name = 'usuarios_modulos';
    protected $_referenceMap = array(
        'Usuario' => array(
            'refTableClass' => 'Usuarios_Db',
            'refColumns' => 'id',
            'columns' => array('usuario_id')
        ),
        'Modulo' => array(
            'refTableClass' => 'Modulos_Db',
            'refColumns' => 'id',
            'columns' => array('modulo_id')
        )
    );
}

