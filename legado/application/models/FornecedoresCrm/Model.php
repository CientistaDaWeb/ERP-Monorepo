<?php

class FornecedoresCrm_Model extends WS_Model {

    protected $_status;

    public function __construct() {
        $this->_db = new FornecedoresCrm_Db();
        $this->_title = 'Gerenciador de Atendimentos à Fornecedores';
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
            'fornecedor_id' => array(
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
                ->from(array('crm' => 'fornecedores_crm'), array('descricao', 'data'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = crm.fornecedor_id', array('razao_social', 'fornecedor_id' => 'id'))
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
                ->from(array('fc' => 'fornecedores_crm'), array('data', 'status', 'id', 'descricao'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = fc.usuario_id', array('nome'))
                ->joinInner(array('f' => 'fornecedores'), 'f.id = fc.fornecedor_id', array('fornecedor' => 'razao_social', 'fornecedor_id' => 'id'))
                ->order('fc.data ASC')
                ->where('fc.data >= ?', WS_Date::adjustToDb($data['data_inicial']))
                ->where('fc.data <= ?', WS_Date::adjustToDb($data['data_final']));

        if (!empty($data['status'])):
            $sql->where('fc.status = ?', $data['status']);
        endif;

        if (!empty($data['fornecedor_id'])):
            $sql->where('f.id = ?', $data['fornecedor_id']);
        endif;

        if (!empty($data['usuario_id'])):
            $sql->where('fc.usuario_id = ?', $data['usuario_id']);
        endif;

        $itens = $sql->query()->fetchAll();
        return $itens;
    }

    public function ajusteRelatorio(array $itens) {
        $WD = new WS_Date();
        foreach ($itens AS $item):
            $var['item_status'] = $this->getOption('status', $item['status']);
            $var['item_data'] = WS_Date::adjustToView($item['data']);
            $var['item_fornecedor'] = $item['razao_social'];
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

    public function buscarPorFornecedor($fornecedor_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('fc' => 'fornecedores_crm'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = fc.usuario_id', array('nome'))
                ->where('fc.fornecedor_id = ?', $fornecedor_id)
                ->order('fc.data DESC');
        $itens = $sql->query()->fetchAll();
        return $itens;
    }

}
