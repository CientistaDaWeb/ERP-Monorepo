<?php

class AdministradoresCrm_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new AdministradoresCrm_Db();
        $this->_title = 'Gerenciador de Atendimentos à Administradores';
        $this->_singular = 'Atendimento';
        $this->_plural = 'Atendimentos';

        $this->_status = array(
            'A' => 'Aberto',
            'R' => 'Resolvido'
        );

        parent::__construct();
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'administrador_id' => array(
                'type' => 'Hidden',
                'required' => true
            ),
            'usuario_id' => array(
                'type' => 'Select',
                'label' => 'Funcionário',
                'required' => true,
                'options' => Usuarios_Model::fetchPair()
            ),
            'data' => array(
                'type' => 'Date',
                'label' => 'Data',
                'required' => true
            ),
            'descricao' => array(
                'type' => 'Textarea',
                'label' => 'Descrição',
                'required' => true
            ),
            'status' => array(
                'type' => 'Select',
                'label' => 'Status do Atendimento',
                'required' => true,
                'options' => $this->_status
            )
        );
    }

    public function adjustToView(array $data) {
        if ($data['status'] == 'R'):
            $data['class'] = 'pago';
        else:
            $data['class'] = 'atrasada';
        endif;
        return parent::adjustToView($data);
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'status' => 'getOption'
        );
    }

    public function setStatus($id, $status) {
        $data['status'] = $status;
        $where = $this->_db->getAdapter()->quoteInto('id = ?', $id);
        $this->_db->update($data, $where);
    }

    public function atendimentosAbertos() {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('crm' => 'administradores_crm'), array('descricao', 'data'))
                ->joinInner(array('c' => 'administradores_condominios'), 'c.id = crm.administrador_id', array('razao_social', 'administrador_id' => 'id'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = crm.usuario_id', array('nome'))
                ->where('crm.status = "A"')
                ->where('data <= ?', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 15, date('Y'))))
                ->order('data ASC');
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

    public function relatorio($data) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cc' => 'administradores_crm'), array('data', 'status', 'id', 'descricao'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = cc.usuario_id', array('nome'))
                ->joinInner(array('c' => 'administradores_condominios'), 'c.id = cc.administrador_id', array('administrador' => 'razao_social', 'administrador_id' => 'id'))
                ->order('cc.data ASC')
                ->where('cc.data >= ?', WS_Date::adjustToDb($data['data_inicial']))
                ->where('cc.data <= ?', WS_Date::adjustToDb($data['data_final']));

        if (!empty($data['status'])):
            $sql->where('cc.status = ?', $data['status']);
        endif;

        if (!empty($data['administrador_id'])):
            $sql->where('c.id = ?', $data['administrador_id']);
        endif;

        if (!empty($data['usuario_id'])):
            $sql->where('cc.usuario_id = ?', $data['usuario_id']);
        endif;

        $itens = $sql->query()->fetchAll();
        return $itens;
    }

    public function ajusteRelatorio(array $itens) {
        $WD = new WS_Date();
        foreach ($itens AS $item):
            $var['item_status'] = $this->getOption('status', $item['status']);
            $var['item_data'] = WS_Date::adjustToView($item['data']);
            $var['item_administrador'] = $item['razao_social'];
            $var['item_descricao'] = $item['descricao'];
            $var['item_funcionario'] = $item['nome'];
            $retorno[] = $var;
        endforeach;
        return $retorno;
    }

    public function montaRelatorio($data, $formato = 'pdf') {
        try {
            $itens = $this->relatorio($data);
            $itens = $this->ajusteRelatorio($itens);

            $phpLiveDocx = new WS_LiveDocx_Model();
            $phpLiveDocx->setRemoteTemplate('RelatorioAtendimentos.docx');

            $phpLiveDocx
                    ->assign('data_inicial', WS_Date::adjustToView($data['data_inicial']))
                    ->assign('data_final', WS_Date::adjustToView($data['data_final']))
                    ->assign('total', count($itens))
                    ->assign('item', $itens);
            $phpLiveDocx->createDocument();

            $document = $phpLiveDocx->retrieveDocument($formato);
            return $document;
        } catch (Zend_Service_LiveDocx_Exception $e) {
            return $e->getMessage();
        }
    }

    public function buscarPorAdministrador($administrador_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cc' => 'administradores_crm'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = cc.usuario_id', array('nome'))
                ->where('cc.administrador_id = ?', $administrador_id)
                ->order('cc.data DESC')
                ->order('cc.id DESC');
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

}
