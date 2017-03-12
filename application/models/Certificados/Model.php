<?php

class Certificados_Model extends WS_Model {

    protected $_tipo;

    public function __construct() {
        $this->_db = new Certificados_Db();
        $this->_title = 'Gerenciador de Certificados';
        $this->_singular = 'Certificado';
        $this->_plural = 'Certificados';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'c.id';

        $this->_tipo_efluente = array(
            'F' => 'Lodo de Fossa Séptica',
            'E' => 'Efluente de Cabine de Pintura'
        );

        parent::__construct();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('*'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array('mtr'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->joinLeft(array('ps' => 'pesquisa_satisfacao'), 'c.id = ps.certificado_id', array('pesquisa' => 'certificado_id'))
        ;
    }

    public function adjustToView(array $data) {
        $data['codigo'] = $data['orcamento_id'] . '.' . $data['sequencial'];
        $data['lembrete'] = '';
        if (!$data['pesquisa']):
            $data['lembrete'] = '<a class="buttonLink" title="Lembrar da pesquisa" href="/erp/Certificados/lembretepesquisa/' . $data['id'] . '" target="_blank">Lembrar da pesquisa</a>';
        endif;
        return parent::adjustToView($data);
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'tipo_efluente' => 'getOption',
            'inicio_tratamento' => 'date',
            'fim_tratamento' => 'date'
        );
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'sequencial' => array(
                'label' => 'Sequencial',
                'type' => 'Number',
                'required' => true
            ),
            'mtr_id' => array(
                'type' => 'Hidden'
            ),
            'quantidade' => array(
                'type' => 'Text',
                'label' => 'Quantidade',
                'required' => true
            ),
            'cliente_nome' => array(
                'type' => 'Text',
                'label' => 'Cliente',
                'required' => true
            ),
            'cliente_endereco' => array(
                'type' => 'Text',
                'label' => 'Endereço do Cliente',
                'required' => true
            ),
            'cliente_cidade' => array(
                'type' => 'Text',
                'label' => 'Cidade do Cliente',
                'required' => true
            ),
            'transportador_nome' => array(
                'type' => 'Text',
                'label' => 'Transportador',
                'required' => true
            ),
            'transportador_endereco' => array(
                'type' => 'Text',
                'label' => 'Endereço do Transportador',
                'required' => true
            ),
            'transportador_lo' => array(
                'type' => 'Text',
                'label' => 'LO do Transportador',
                'required' => true
            ),
            'tipo_efluente' => array(
                'type' => 'Select',
                'label' => 'Tipo de Efluente',
                'required' => true,
                'options' => $this->listOptions('tipo_efluente')
            ),
            'inicio_tratamento' => array(
                'type' => 'Date',
                'label' => 'Início do Tratamento',
                'required' => true
            ),
            'fim_tratamento' => array(
                'type' => 'Date',
                'label' => 'Fim do Tratamento',
                'required' => true
            ),
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'inicio_tratamento' => 'desc'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'codigo' => 'Código',
            'cliente' => 'Cliente',
            'inicio_tratamento' => 'Início do Tratamento',
            'quantidade' => 'Quantidade',
            'tipo_efluente' => 'Tipo de Efluente',
            'lembrete' => 'Pesquisa',
        );
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'cl.razao_social' => 'text',
            'c.inicio_tratamento' => 'date',
            'c.tipo_efluente' => 'getKey',
            'o.id' => 'text',
            'c.quantidade' => 'text',
        );
    }

    public function buscarPorCliente($cliente_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('id', 'quantidade', 'tipo_efluente', 'sequencial', 'mtr_id'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->where('o.cliente_id = ?', $cliente_id);
        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscaParaCron() {
        $inicio = new WS_Date();
        $fim = new WS_Date();
        $inicio = $inicio->sub('15', ZEND_DATE::DAY);
        $fim = $fim->sub('16', ZEND_DATE::DAY);

        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('id', 'quantidade', 'tipo_efluente', 'sequencial', 'mtr_id'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinLeft(array('ps' => 'pesquisa_satisfacao'), 'c.id = ps.certificado_id', array('pesquisa_id' => 'id'))
                ->where('c.fim_tratamento >= ?', WS_Date::adjustToDb($fim))
                ->where('c.fim_tratamento <= ?', WS_Date::adjustToDb($inicio))
                ->where('ps.id IS NULL')
        ;

        echo $consulta;
        exit();

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function buscarPorMtr($mtr_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('id'))
                ->where('c.mtr_id = ?', $mtr_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function buscarDadosEmail($certificado_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('ce' => 'certificados'), array('sequencial', 'id'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = ce.mtr_id', array())
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('data_coleta'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('orcamento_id' => 'id'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('email', 'contato', 'cliente_id' => 'id', 'usuario', 'senha', 'email_pesquisa'))
                ->joinInner(array('u' => 'usuarios'), 'u.id = o.usuario_id', array('nome', 'telefone', 'emailf' => 'email'))
                ->joinLeft(array('ac' => 'administradores_condominios'), 'ac.id = c.administrador_id', array('emaila' => 'email'))
                ->where('ce.id = ?', $certificado_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function gerarPdf($id) {
        $item = $this->find($id);
        $item = $this->adjustToView($item);
        try {
            $phpLiveDocx = new WS_LiveDocx_Model();
            $WD = new WS_Date();
            $phpLiveDocx->setRemoteTemplate('Certificado.docx');
            $phpLiveDocx
                    ->assign('numero', $item['orcamento_id'] . '.' . $item['sequencial'])
                    ->assign('cliente_nome', $item['cliente_nome'])
                    ->assign('cliente_endereco', $item['cliente_endereco'])
                    ->assign('cliente_cidade', $item['cliente_cidade'])
                    ->assign('transportador_nome', $item['transportador_nome'])
                    ->assign('transportador_endereco', $item['transportador_endereco'])
                    ->assign('transportador_lo', $item['transportador_lo'])
                    ->assign('data', $item['inicio_tratamento'])
                    ->assign('tratamento', $item['inicio_tratamento'] . ' - ' . $item['fim_tratamento'])
                    ->assign('mtr', $item['mtr'])
                    ->assign('quantidade', $item['quantidade'])
                    ->assign('tipo_efluente', $item['tipo_efluente'])
                    ->assign('hoje', $item['fim_tratamento'])
            ;
            $phpLiveDocx->createDocument();

            $document = $phpLiveDocx->retrieveDocument('pdf');

            $WSFile = new WS_File();
            $arquivo = 'Certificado_' . $item['orcamento_id'] . '_' . $item['id'] . '.pdf';
            $WSFile->remove(UPLOAD_PATH . 'certificados/' .$arquivo);

            file_put_contents(UPLOAD_PATH . 'certificados/' . $arquivo, $document);
        } catch (Zend_Service_LiveDocx_Exception $e) {
            echo $e->getMessage();
        }
    }

    public function geraCertificado($mtr_id) {
        $certificado = $this->buscarPorMtr($mtr_id);
        if (empty($certificado['id'])):
            $WD = new WS_Date();
            $item = $this->pegaDados($mtr_id);

            if (!empty($item)):
                $inicio_tratamento = new Zend_Date($item['data_coleta']);
                $fim_tratamento = new Zend_Date($item['data_coleta']);
                $fim_tratamento = $fim_tratamento->add(4, Zend_DATE::DAY);

                $data['mtr_id'] = $mtr_id;
                $data['cliente_nome'] = $item['razao_social'];
                $data['cliente_endereco'] = $item['endereco'] . ', ' . $item['numero'] . ' ' . $item['complemento'] . ' - ' . $item['bairro'];
                $data['cliente_cidade'] = $item['cidade'] . ' - ' . $item['uf'];
                $data['transportador_nome'] = $item['tnome'];
                $data['transportador_endereco'] = $item['tendereco'] . ', ' . $item['tnumero'] . ' ' . $item['tcomplemento'] . ' - ' . $item['tbairro'] . ' - ' . $item['tcidade'] . ' - ' . $item['tuf'];
                $data['transportador_lo'] = $item['lo'];
                $data['quantidade'] = $item['volume'];
                $data['inicio_tratamento'] = WS_Date::adjustToDb($inicio_tratamento);
                $data['fim_tratamento'] = WS_Date::adjustToDb($fim_tratamento);

                $sequencial = $this->getSequencial($mtr_id);
                if (!empty($sequencial)):
                    $data['sequencial'] = $sequencial['sequencial'] + 1;
                else:
                    $data['sequencial'] = 1;
                endif;

                $id = $this->_db->insere($data, $this->getOption('messages', 'add'), $this->_db->getTableName());
                return $id;
            else:
                return false;
            endif;
        else:
            return $certificado['id'];
        endif;
    }

    public function pegaDados($mtr_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'mtrs'), array('*'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id', 'data_coleta'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('t' => 'transportadores'), 't.id = os.transportador_id', array('lo', 'tnome' => 'razao_social', 'tendereco' => 'endereco', 'tbairro' => 'bairro', 'tnumero' => 'numero', 'tcomplemento' => 'complemento'))
                ->joinInner(array('mu' => 'municipios'), 'mu.id = t.municipio_id', array('tcidade' => 'nome'))
                ->joinInner(array('e2' => 'estados'), 'e2.id = t.estado_id', array('tuf' => 'uf'))
                ->joinInner(array('c' => 'clientes'), 'c.id = o.cliente_id', array('razao_social'))
                ->joinInner(array('ce' => 'clientes_enderecos'), 'ce.id = m.endereco_id', array('bairro', 'endereco', 'numero', 'complemento'))
                ->joinInner(array('mu2' => 'municipios'), 'mu2.id = ce.municipio_id', array('cidade' => 'nome'))
                ->joinInner(array('e' => 'estados'), 'e.id = ce.estado_id', array('uf'))
                ->joinInner(array('oss' => 'ordens_servico_servicos'), 'os.id = oss.ordem_servico_id', array('volume' => 'SUM(oss.qtde)'))
                ->joinInner(array('s' => 'servicos'), 's.id = oss.servico_id AND s.certificado = "S"', array(''))
                ->group('s.id')
                ->group('os.id')
                ->group('oss.id')
                ->group('c.id')
                ->group('ce.id')
                ->group('m.id')
                ->order('volume DESC')
                ->where('m.id = ?', $mtr_id);
        $item = $consulta->query()->fetch();
        return $item;
    }

    public function getSequencial($mtr_id) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('m' => 'mtrs'), array(''))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array(''))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array('id'))
                ->where('m.id = ?', $mtr_id);
        $item = $consulta->query()->fetch();

        if (!empty($item['id'])):
            $consulta = $this->_db->select()
                    ->setIntegrityCheck(false)
                    ->from(array('c' => 'certificados'), array('sequencial' => 'MAX(c.sequencial)'))
                    ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array(''))
                    ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array(''))
                    ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                    ->where('o.id = ?', $item['id']);
            $item = $consulta->query()->fetch();
            return $item;
        else:
            return 'Orçamento não encontrado!';
        endif;
    }

    public function getByCliente($cliente_id) {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'certificados'), array('*'))
                ->joinInner(array('m' => 'mtrs'), 'm.id = c.mtr_id', array('mtr'))
                ->joinInner(array('os' => 'ordens_servico'), 'os.id = m.ordem_servico_id', array('orcamento_id'))
                ->joinInner(array('o' => 'orcamentos'), 'o.id = os.orcamento_id', array(''))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = o.cliente_id', array('cliente' => 'razao_social'))
                ->where('cl.id = ?', $cliente_id);
        return $sql->query()->fetchAll();
    }

}
