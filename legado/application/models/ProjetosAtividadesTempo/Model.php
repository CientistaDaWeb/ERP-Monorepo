<?php

class ProjetosAtividadesTempo_Model extends WS_Model {

    private $_tarefa_concluida;

    public function __construct() {
        $this->_db = new ProjetosAtividadesTempo_Db();
        $this->_title = 'Gerenciador de Tempo de Atividades de Projetos';
        $this->_singular = 'Tempo de Atividade de Projeto';
        $this->_plural = 'Tempos de Atividades de Projetos';
        $this->_primary = 'pat.id';
        $this->_layoutList = 'basic';

        $this->_tarefa_concluida = array('S' => 'Sim', 'N' => 'Não');

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pat' => 'projetos_atividades_tempo'), array('*'))
                ->joinInner(array('pa' => 'projetos_atividades'), 'pa.id = pat.projeto_atividade_id', array(''))
                ->joinInner(array('p' => 'projetos'), 'p.id = pa.projeto_id', array(''))
                ->joinInner(array('u' => 'usuarios'), 'u.id = pat.usuario_id', array('usuario' => 'nome'))
        ;
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'projeto_atividade_id' => array(
                'type' => 'Hidden'
            ),
            'minutos' => array(
                'type' => 'Number',
                'label' => 'Minutos',
                'required' => true
            ),
            'data' => array(
                'type' => 'Date',
                'label' => 'Data',
                'required' => true
            ),
            'hora' => array(
                'type' => 'Hour',
                'label' => 'Hora',
                'required' => true
            ),
            'tarefa_concluida' => array(
                'type' => 'Select',
                'label' => 'Tarefa Concluída',
                'options' => $this->_tarefa_concluida,
                'ignore' => true
            )
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'hora' => 'time',
        );
    }

    public function getStatus($projeto_atividade_id, $usuario_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pat' => 'projetos_atividades_tempo'), array('id'))
                ->where('pat.projeto_atividade_id = ?', $projeto_atividade_id)
                ->where('pat.usuario_id = ?', $usuario_id)
                ->where('pat.minutos IS NULL');
        $consulta = $sql->query()->fetch();
        if (!empty($consulta)):
            return $consulta['id'];
        else:
            return false;
        endif;
    }

    public function iniciar($projeto_atividade_id, $usuario_id) {
        $auth = new WS_Auth('erp');
        if ($auth->hasIdentity()):
            $usuario = $auth->getIdentity();

            $data['created'] = date('Y-m-d H:i:s');
            $data['projeto_atividade_id'] = $projeto_atividade_id;
            $data['usuario_id'] = $usuario->id;
            $data['data'] = date('Y-m-d');
            $data['hora'] = date('H:i:s');
            try {
                $this->_db->insert($data, $this->getOption('messages', 'add'), $this->_db->getTableName());
                return array('tipo' => 'sucess', 'mensagem' => 'Atividade Iniciada com sucesso');
            } catch (Exception $e) {
                return array('tipo' => 'error', 'mensagem' => 'Erro: ' . $e->getMessage());
            }
        endif;
    }

}
