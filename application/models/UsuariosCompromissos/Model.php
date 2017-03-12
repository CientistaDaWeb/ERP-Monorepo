<?php

class UsuariosCompromissos_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new UsuariosCompromissos_Db();
        $this->_title = 'Gerenciador de Compromissos';
        $this->_singular = 'Compromisso';
        $this->_plural = 'Compromissos';

        $this->_status = array(
            'A' => 'Aguardando',
            'C' => 'Concluído'
        );

        parent::__construct();
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'status' => 'getOption',
            'cliente_id' => 'int',
        );
    }

    public function compromissos($usuario_id = null) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'usuarios_compromissos'), array('*'))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = c.cliente_id', array('cliente' => 'razao_social'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = c.usuario_id', array('nome'))
                ->where('data <= ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y'))))
                ->where('data >= ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'))))
                ->where('status = "A"')
                ->order('data ASC')
                ->order('hora ASC')
                ->group('c.id');

        if ($usuario_id):
            $consulta->where('u.id = ?', $usuario_id);
        endif;

        return $consulta->query()->fetchAll();
    }

    public function agenda($inicio, $fim, $usuario_id = NULL) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'usuarios_compromissos'), array('*'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = c.usuario_id', array('nome'))
                ->joinLeft(array('cl' => 'clientes'), 'cl.id = c.cliente_id', array('cliente' => 'razao_social'))
                ->where('c.data >= ?', $inicio)
                ->where('c.data <= ?', $fim);

        if ($usuario_id):
            $consulta->where('u.id = ?', $usuario_id)
                    ->joinInner(array('l' => 'logs_alteracoes'), 'l.object_id = c.id', array(''))
                    ->where('l.action = ?', 'I')
                    ->where('l.table = ?', 'usuarios_compromissos')
                    ->joinInner(array('ud' => 'usuarios'), 'l.usuario_id = ud.id', array('dono' => 'nome'))
            ;
        else:
            $consulta->where('u.id != ?', '6');
        endif;

        return $consulta->query()->fetchAll();
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('uc' => 'usuarios_compromissos'), array('*'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = uc.usuario_id', array('nome'))
                ->where('uc.data >= ?', WS_Date::adjustToDb($data['data_inicial']))
                ->where('uc.data <= ?', WS_Date::adjustToDb($data['data_final']))
        ;

        if (!empty($data['status'])):
            $consulta->where('uc.status = ?', $data['status']);
        endif;

        if (!empty($data['usuario_id'])):
            $consulta->where('u.id = ?', $data['usuario_id']);
        endif;

        return $consulta->query()->fetchAll();
    }

}
