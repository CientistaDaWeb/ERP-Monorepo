<?php

class ProjetosPpci_Model extends WS_Model {

    public function __construct() {
        $this->_db = new ProjetosPpci_Db();
        $this->_title = 'Gerenciador de Alterações PPCI em Projetos';
        $this->_singular = 'Alteração PPCI em Projeto';
        $this->_plural = 'Alterações PPCI em Projetos';
        $this->_primary = 'pp.id';
        $this->_layoutList = 'basic';

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('pp' => 'projetos_ppci'), array('*'))
                ->joinInner(array('p' => 'projetos'), 'p.id = pp.projeto_id', array('projeto' => 'nome'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = pp.usuario_id', array('usuario' => 'nome'));
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date'
        );
    }

    public function adjustToDb(array $data) {
        if (empty($data['arquivo'])):
            unset($data['arquivo']);
        endif;
        if (empty($data['data'])):
            $data['data'] = date('d/m/Y');
        endif;
        if (empty($data['hora_inicial'])):
            $data['hora_inicial'] = '00:00:00';
        endif;
        if (empty($data['hora_final'])):
            $data['hora_final'] = '00:00:00';
        endif;
        return parent::adjustToDb($data);
    }

    public function adjustToView(array $data) {
        if ($data['hora_final'] != '00:00:00'):
            $diferenca = WS_Date::dateDifference($data['data'] . ' ' . $data['hora_final'], $data['data'] . ' ' . $data['hora_inicial']);
            $data['horas'] = number_format($diferenca['minutes_total'] / 60, 1);
        else:
            $data['horas'] = 0;
        endif;

        return parent::adjustToView($data);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'arquivo' => array(
                'type' => 'Hidden',
            ),
            'projeto_id' => array(
                'type' => 'Hidden'
            ),
            'usuario_id' => array(
                'label' => 'Funcionário',
                'type' => 'Hidden',
                'options' => Usuarios_Model::fetchPair(),
                'required' => true
            ),
            'data' => array(
                'type' => 'Hidden',
                'label' => 'Data',
            ),
            'descricao' => array(
                'type' => 'Textarea',
                'label' => 'Descrição',
                'required' => false
            ),
            'hora_inicial' => array(
                'type' => 'Hidden',
                'label' => 'Hora Inicial',
                'required' => false
            ),
            'hora_final' => array(
                'type' => 'Hidden',
                'label' => 'Hora Final',
                'required' => false
            ),
            'upload' => array(
                'type' => 'File',
                'label' => 'Arquivo',
                'ignore' => true,
                'extension' => array('dwg', 'dxf', 'prh', 'doc', 'docx', 'xls', 'xlsx'),
                'size' => array('max' => '62728640', 'min' => '0'),
            ),
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'data' => 'Data',
            'descricao' => 'Descrição',
            'horas' => 'Horas',
            'arquivo' => 'Arquivo',
            'acao' => 'Ação',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'pp.data' => 'date',
            'pp.descricao' => 'descricao',
        );
    }

    public function getByProject($projeto_id) {
        $sql = clone($this->_basicSearch);
        $sql->where('p.id = ?', $projeto_id)
                ->group('pp.id');
        return $sql->query()->fetchAll();
    }

    public function getHoursWorked($projeto_id) {
        $datas = $this->getByProject($projeto_id);
        $total = 0;
        foreach ($datas as $data):
            if ($data['hora_final'] != '00:00:00'):
                $diferenca = WS_Date::dateDifference($data['data'] . ' ' . $data['hora_final'], $data['data'] . ' ' . $data['hora_inicial']);
                $data['horas'] = number_format($diferenca['minutes_total'] / 60, 1);
            else:
                $data['horas'] = 0;
            endif;
            $total += $data['horas'];
        endforeach;
        return $total;
    }

    public function relatorio($projeto_id, $data) {
        $sql = clone($this->_basicSearch);
        $sql->where('p.id IN (?)', $projeto_id);
        if (!empty($data['usuario_id'])):
            $sql->where('pp.usuario_id = ?', $data['usuario_id']);
        endif;
        if(!empty($data['data_inicial'])):
            $sql->where('pp.data >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if(!empty($data['data_final'])):
            $sql->where('pp.data <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;

        return $sql->query()->fetchAll();
    }

}

