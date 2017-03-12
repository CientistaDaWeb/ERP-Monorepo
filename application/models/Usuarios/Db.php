<?php

class Usuarios_Db extends Erp_Db_Table {

    protected $_name = 'usuarios';
    protected $_dependenceTables = array('Logs_Db', 'LogsAcesso_Db', 'ClientesCrm_Db', 'UsuariosCompromissos_Db');

}