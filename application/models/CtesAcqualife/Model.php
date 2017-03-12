<?php

class CtesAcqualife_Model extends WS_Model {

    protected $_status, $_doc_tipo, $_campos;

    public function __construct() {
        $this->_db = new CtesAcqualife_Db();
        $this->_title = 'Gerenciador de Ctes Acqualife';
        $this->_singular = 'Cte Acqualife';
        $this->_plural = 'Ctes Acqualife';
        $this->_layoutList = 'basic';
        $this->_layoutForm = false;
        $this->_primary = 'c.id';

        $this->_status = array(
            '1' => 'Adicione Faturas',
            '2' => 'Gere o XML',
            '3' => 'Valide o Arquivo',
            '4' => 'Transmita o Arquivo',
            '5' => 'Gere os Arquivos',
            '6' => 'Envie os Arquivos',
            '7' => 'Enviada',
            '8' => 'Excluída',
            '9' => 'Cancelada',
            '10' => 'Invalidada',
            '11' => 'Inutilizada',
        );

        $this->_doc_tipo = array(
            '00' => 'Declaração',
            '01' => 'Dutoviário',
            '99' => 'Outros',
        );

        $this->_toma = array(
            '0' => 'Remetente',
            '1' => 'Expedidor',
            '2' => 'Recebedor',
            '3' => 'Destinatário',
        );

        $this->_campos = array(
            'cfop' => array(
                'grupo' => 'ide',
                'campo' => 'CFOP',
                'type' => 'Select',
                'option' => array('' => 'Selecione ...'),
                'options' => Cfops_Model::fetchPair()
            ),
        );

        parent::__construct();
        parent::turningFemale();
    }

    public function setBasicSearch() {
        $this->_basicSearch = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'ctes_acqualife'), array('*'))
                ->joinInner(array('cl' => 'clientes'), 'cl.id = c.cliente_id', array('remetente' => 'razao_social', 'remetente_id' => 'id'))
                ->joinInner(array('cl2' => 'clientes'), 'cl2.id = c.destinatario_id', array('destinatario' => 'razao_social'))
                ->joinLeft(array('cl3' => 'clientes'), 'cl3.id = c.expedidor_id', array('expedidor' => 'razao_social'))
                ->joinLeft(array('cl4' => 'clientes'), 'cl4.id = c.recebedor_id', array('recebedor' => 'razao_social'))
                ->joinLeft(array('cr' => 'contas_receber'), 'cr.cte_acqualife_id = c.id', array('total' => 'SUM(cr.valor-cr.valor_retido)', 'faturas' => 'COUNT(cr.id)'))
                ->joinInner(array('cf' => 'cfops'), 'cf.id = c.cfop_id', array('cfop_codigo' => 'codigo', 'cfop_descricao' => 'descricao'))
                ->group('c.id');
    }

    public function setSearchFields() {
        $this->_searchFields = array(
            'c.data' => 'text',
            'cl2.razao_social' => 'text',
            'cl.razao_social' => 'text',
        );
    }

    public function adjustToDb(array $data) {
        if (empty($data['codigo'])):
            $configs = Zend_Registry::get('application');
            $ambiente = $configs->cte->ambiente->codigo;
            $cte = $this->buscaUltimoId();
            if (empty($cte)):
                $cte['id'] = 0;
            endif;

            $chave = rand(10000000, 99999999);
            $data['chave'] = $chave;
            $id = $cte['id'] + 1;
            $data['codigo'] = $this->calcula_chave_acesso('43', date('ym'), '23661925000189', '57', '001', substr('00000000' . $id, -9), '1', $chave);
        endif;
        if (empty($data['expedidor_id'])):
            unset($data['expedidor_id']);
            unset($data['expedidor_endereco_id']);
        endif;
        if (empty($data['recebedor_id'])):
            unset($data['recebedor_id']);
            unset($data['recebedor_endereco_id']);
        endif;
        return parent::adjustToDb($data);
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data' => 'date',
            'status' => 'getOption',
            'doc_tipo' => 'getOption',
            'toma' => 'getOption',
            'doc_data_emissao' => 'date',
            'doc_valor' => 'money',
            'total' => 'money',
            'nfe_data_emissao' => 'date',
            'valor_carga' => 'money',
        );
    }

    public function getFormFieldsArquivos($cte_id, $email = 'acquasana@acquasana.com.br', $assunto = '', $mensagem = '') {
        $form = array(
            'cte_id' => array(
                'type' => 'Hidden',
                'value' => $cte_id,
                'required' => true
            ),
            'destinatarios' => array(
                'type' => 'Text',
                'label' => 'Destinatários',
                'value' => $email,
                'required' => true
            ),
            'assunto_template' => array(
                'type' => 'Select',
                'label' => 'Modelo de Assunto',
                'option' => array('' => 'Usar Template'),
                'options' => Textos_Model::getByCategoria(11),
                'ignore' => true
            ),
            'assunto' => array(
                'type' => 'Text',
                'label' => 'Assunto',
                'value' => $assunto,
                'required' => true
            ),
            'mensagem_template' => array(
                'type' => 'Select',
                'label' => 'Modelo de Mensagem',
                'option' => array('' => 'Usar Template'),
                'options' => Textos_Model::getByCategoria(12),
                'ignore' => true
            ),
            'mensagem' => array(
                'type' => 'Textarea',
                'label' => 'Mensagem',
                'value' => $mensagem,
                'required' => true
            ),
        );
        return $form;
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'status' => array(
                'type' => 'Hidden',
                'value' => 1
            ),
            'codigo' => array(
                'type' => 'Hidden',
            ),
            'chave' => array(
                'type' => 'Hidden',
            ),
            'data' => array(
                'label' => 'Data',
                'type' => 'Date',
                'required' => true
            ),
            'cfop_id' => array(
                'label' => 'CFOP',
                'type' => 'Select',
                'option' => array('' => 'Selecione o CFOP'),
                'options' => Cfops_Model::fetchPair(),
                'required' => true,
            ),
            'toma' => array(
                'label' => 'Tomador do Serviço',
                'type' => 'Select',
                'options' => $this->_toma,
            ),
            'cliente_id' => array(
                'label' => 'Remetente',
                'type' => 'Select',
                'option' => array('' => 'Selecione o Cliente'),
                'options' => Clientes_Model::fetchPair(),
                'required' => true,
            ),
            'endereco_id' => array(
                'label' => 'Endereco',
                'type' => 'Select',
                'option' => array('' => 'Selecione o Endereço'),
                'options' => ClientesEnderecos_Model::fetchPair(),
                'required' => true,
            ),
            'destinatario_id' => array(
                'label' => 'Destinatário',
                'type' => 'Select',
                'option' => array('' => 'Selecione o Destinatário'),
                'options' => Clientes_Model::fetchPair(),
                'required' => true,
            ),
            'destinatario_endereco_id' => array(
                'label' => 'Endereco do Destinatario',
                'type' => 'Select',
                'option' => array('' => 'Selecione o Endereço'),
                'options' => ClientesEnderecos_Model::fetchPair(),
                'required' => true,
            ),
            'expedidor_id' => array(
                'label' => 'Expedidor',
                'type' => 'Select',
                'option' => array('0' => 'Nenhum Expedidor'),
                'options' => Clientes_Model::fetchPair(),
            ),
            'expedidor_endereco_id' => array(
                'label' => 'Endereco do Expedidor',
                'type' => 'Select',
                'option' => array('0' => 'Selecione o Expedidor'),
                'options' => ClientesEnderecos_Model::fetchPair(),
            ),
            'recebedor_id' => array(
                'label' => 'Recebedor',
                'type' => 'Select',
                'option' => array('0' => 'Nenhum Recebedor'),
                'options' => Clientes_Model::fetchPair(),
            ),
            'recebedor_endereco_id' => array(
                'label' => 'Endereco do Recebedor',
                'type' => 'Select',
                'option' => array('0' => 'Selecione o Recebedor'),
                'options' => ClientesEnderecos_Model::fetchPair(),
            ),
            'rtnrc' => array(
                'label' => 'RTNRC',
                'type' => 'Text',
                'required' => true,
                'value' => '49073900',
            ),
            'quantidade' => array(
                'label' => 'Volume (m³)',
                'type' => 'Number',
                'required' => true,
            ),
            'observacoes' => array(
                'label' => 'Observações',
                'type' => 'Text',
            ),
            'doc_tipo' => array(
                'label' => 'Documentos Originários - Tipo',
                'type' => 'Select',
                'option' => array('' => 'Sem Documentos Originários'),
                'options' => $this->_doc_tipo,
            ),
            'doc_numero' => array(
                'label' => 'Documentos Originários - Número do documento',
                'type' => 'Text',
            ),
            'doc_descricao' => array(
                'label' => 'Documentos Originários - Descrição',
                'type' => 'Text',
            ),
            'doc_data_emissao' => array(
                'label' => 'Documentos Originários - Data de Emissão',
                'type' => 'Date',
            ),
            'doc_valor' => array(
                'label' => 'Documentos Originários - Valor',
                'type' => 'Money',
            ),
            'nfe_chave' => array(
                'label' => 'NFE - Chave',
                'type' => 'Text',
            ),
            'nfe_pin' => array(
                'label' => 'NFE - PIN',
                'type' => 'Text',
            ),
            'nfe_data_emissao' => array(
                'label' => 'NFE - Data de Previsão',
                'type' => 'Date',
            ),
            'valor_carga' => array(
                'label' => 'Valor da Carga',
                'type' => 'Money',
            ),
        );
    }

    public function setOrderFields() {
        $this->_orderFields = array(
            'data' => 'DESC',
            'id' => 'DESC'
        );
    }

    public function setViewFields() {
        $this->_viewFields = array(
            'id' => 'Ct-e',
            'data' => 'Data',
            'faturas' => 'Faturas',
            'total' => 'Total',
            'remetente' => 'Remetente',
            'destinatario' => 'Destinatário',
            'status' => 'Status',
            'boletos' => 'Boletos',
        );
    }

    public function buscarPorCliente($cliente_id) {
        $sql = clone($this->_basicSearch);
        $sql->where('cl.id = ?', $cliente_id);
        return $sql->query()->fetchAll();
    }

    public function buscaUltimoId() {
        $sql = $this->_db->select()
                ->from(array('c' => 'ctes_acqualife'), array('id'))
                ->order('id DESC')
                ->limit(1);

        $resultado = $sql->query()->fetch();
        if ($resultado):
            return $resultado;
        endif;
    }

    public function calcula_dv($chave43) {
        $multiplicadores = array(2, 3, 4, 5, 6, 7, 8, 9);
        $i = 42;
        $soma_ponderada = 0;
        while ($i >= 0) {
            for ($m = 0; $m < count($multiplicadores) && $i >= 0; $m++) {
                $soma_ponderada+= $chave43[$i] * $multiplicadores[$m];
                $i--;
            }
        }
        $resto = $soma_ponderada % 11;
        if ($resto == '0' || $resto == '1') {
            $cDV = 0;
        } else {
            $cDV = 11 - $resto;
        }
        $this->cDV = $cDV;
        return $cDV;
    }

    public function calcula_chave_acesso($cUF, $AAMM, $CNPJ, $mod, $serie, $nCT, $tpEmis, $cCT) {
        /*
          43 1303 09466930000100 57 001 000000018 1 08070005 4
          43 1303 09466930000100 57 001 000000018 1 26177368 1
          · cUF - Código da UF do emitente do Documento Fiscal   2
          · AAMM - Ano e Mês de emissão do CT-e 4
          · CNPJ - CNPJ do emitente 14
          · mod - Modelo do Documento Fiscal 2
          · serie - Série do Documento Fiscal 3
          · nCT - Número do Documento Fiscal 9
          · tpEmis ? Forma de emissão do CT-e 1
          · cCT - Código Numérico que compõe a Chave de Acesso 8
          · cDV - Dígito Verificador da Chave de Acesso 1
         */
// 02 - cUF  - código da UF do emitente do Documento Fiscal
        $chave = sprintf("%02d", $cUF);

// 04 - AAMM - Ano e Mes de emissão da NF-e
        $chave.= sprintf("%04s", $AAMM);

// 14 - CNPJ - CNPJ do emitente
        $chave.= sprintf("%014s", $CNPJ);

// 02 - mod  - Modelo do Documento Fiscal
        $chave.= sprintf("%02d", $mod);

// 03 - serie - Série do Documento Fiscal
        $chave.= sprintf("%03d", $serie);

// 09 - nCT  - Número do Documento Fiscal
        $chave.= sprintf("%09d", $nCT);

// 01 - tpEmis  - Tipo emissão
        $chave.= sprintf("%01d", $tpEmis);

// 08 - cCT  - Código Numérico que compõe a Chave de Acesso // diminui 1 digito na versão 2.0
        $chave.= sprintf("%08d", $cCT);

// 01 - cDV  - Dígito Verificador da Chave de Acesso
        $chave.= $this->calcula_dv($chave);

        return $chave;
    }

    public function adjustToView(array $data) {
        $data['boletos'] = '<a href="/erp/Boleto-Itau/cte/' . base64_encode($data['id']) . '" class="buttonLink" target="_blank">Boletos</a>';
        return parent::adjustToView($data);
    }

    public function geraXml($cte_id, $filename) {
        $cte = $this->find($cte_id);
//$cte = $this->adjustToView($cte);

        $EmpresasModel = new Empresas_Model();
        $empresa = $EmpresasModel->buscaParaCte(3);

        $configs = Zend_Registry::get('application');
        $ambiente = $configs->cte->ambiente->codigo;

        $ClientesModel = new Clientes_Model();
        $ClientesEnderecosModel = new ClientesEnderecos_Model();
        $ClientesTelefonesModel = new ClientesTelefones_Model();

        $cliente = $ClientesModel->find($cte['cliente_id']);
        $cliente['endereco'] = $ClientesEnderecosModel->buscaPorId($cte['endereco_id']);
        $cliente_telefone = $ClientesTelefonesModel->buscarPorCliente($cte['cliente_id']);
        $cliente['telefone'] = $cliente_telefone['0']['telefone'];

        $ClientesModel = new Clientes_Model();
        $destinatario = $ClientesModel->find($cte['destinatario_id']);
        $destinatario['endereco'] = $ClientesEnderecosModel->buscaPorId($cte['destinatario_endereco_id']);
        $destinatario_telefone = $ClientesTelefonesModel->buscarPorCliente($cte['destinatario_id']);
        $destinatario['telefone'] = $destinatario_telefone['0']['telefone'];

        if (!empty($cte['expedidor_id'])):
            $ClientesModel = new Clientes_Model();
            $expedidor = $ClientesModel->find($cte['expedidor_id']);
            $expedidor['endereco'] = $ClientesEnderecosModel->buscaPorId($cte['expedidor_endereco_id']);
            $expedidor_telefone = $ClientesTelefonesModel->buscarPorCliente($cte['expedidor_id']);
            $expedidor['telefone'] = $expedidor_telefone['0']['telefone'];
        endif;

        if (!empty($cte['recebedor_id'])):
            $ClientesModel = new Clientes_Model();
            $recebedor = $ClientesModel->find($cte['recebedor_id']);
            $recebedor['endereco'] = $ClientesEnderecosModel->buscaPorId($cte['recebedor_endereco_id']);
            $recebedor_telefone = $ClientesTelefonesModel->buscarPorCliente($cte['recebedor_id']);
            $recebedor['telefone'] = $recebedor_telefone['0']['telefone'];
        endif;

        $ContasReceberModel = new ContasReceber_Model();
        $fatura = $ContasReceberModel->buscaSomaPorCteAcqualife($cte_id);
        $faturas = $ContasReceberModel->buscaPorCteAcqualife($cte_id);

        $linhas = '<?xml version="1.0" encoding="UTF-8"?>';
        $linhas .= '<CTe xmlns="http://www.portalfiscal.inf.br/cte">';
        $linhas .= '<infCte versao="2.00" Id="CTe' . WS_Text::clearSpaces($cte['codigo']) . '">';
        $linhas .= '<ide>';
        $linhas .= '<cUF>' . WS_Text::clearSpaces($empresa['codigo_uf']) . '</cUF>';
        $linhas .= '<cCT>' . WS_Text::clearSpaces($cte['chave']) . '</cCT>';
        $linhas .= '<CFOP>' . WS_Text::clearSpaces($cte['cfop_codigo']) . '</CFOP>';
        $linhas .= '<natOp>' . WS_Text::clearSpaces(substr($cte['cfop_descricao'], 0, 60)) . '</natOp>';
        $linhas .= '<forPag>1</forPag>';
        $linhas .= '<mod>57</mod>';
        $linhas .= '<serie>1</serie>';
        $linhas .= '<nCT>' . WS_Text::clearSpaces($cte['id']) . '</nCT>';
        $linhas .= '<dhEmi>' . WS_Text::clearSpaces(date('Y-m-d') . 'T' . date('H:i:s')) . '</dhEmi>';
        $linhas .= '<tpImp>1</tpImp>';
        $linhas .= '<tpEmis>1</tpEmis>';
        $linhas .= '<cDV>' . WS_Text::clearSpaces(substr($cte['codigo'], -1)) . '</cDV>';
        $linhas .= '<tpAmb>' . WS_Text::clearSpaces($ambiente) . '</tpAmb>';
        $linhas .= '<tpCTe>0</tpCTe>';
        $linhas .= '<procEmi>3</procEmi>';
        $linhas .= '<verProc>1.2.0</verProc>';
        $linhas .= '<cMunEnv>' . WS_Text::clearSpaces($empresa['codigo_municipio']) . '</cMunEnv>';
        $linhas .= '<xMunEnv>' . WS_Text::clearSpaces($empresa['municipio']) . '</xMunEnv>';
        $linhas .= '<UFEnv>' . WS_Text::clearSpaces($empresa['uf']) . '</UFEnv>';
        $linhas .= '<modal>01</modal>';
        $linhas .= '<tpServ>0</tpServ>';
        $linhas .= '<cMunIni>' . WS_Text::clearSpaces($cliente['endereco']['codigo_municipio']) . '</cMunIni>';
        $linhas .= '<xMunIni>' . WS_Text::clearSpaces($cliente['endereco']['municipio']) . '</xMunIni>';
        $linhas .= '<UFIni>' . WS_Text::clearSpaces($cliente['endereco']['uf']) . '</UFIni>';
        $linhas .= '<cMunFim>' . WS_Text::clearSpaces($destinatario['endereco']['codigo_municipio']) . '</cMunFim>';
        $linhas .= '<xMunFim>' . WS_Text::clearSpaces($destinatario['endereco']['municipio']) . '</xMunFim>';
        $linhas .= '<UFFim>' . WS_Text::clearSpaces($destinatario['endereco']['uf']) . '</UFFim>';
        $linhas .= '<retira>1</retira>';
        $linhas .= '<toma03>';
        $linhas .= '<toma>' . WS_Text::clearSpaces($cte['toma']) . '</toma>'; //Botar para eles setarem
        $linhas .= '</toma03>';
        $linhas .= '</ide>';
        $linhas .= '<compl>';
        $linhas .= '<Entrega>';
        $linhas .= '<semData>';
        $linhas .= '<tpPer>0</tpPer>';
        $linhas .= '</semData>';
        $linhas .= '<semHora>';
        $linhas .= '<tpHor>0</tpHor>';
        $linhas .= '</semHora>';
        $linhas .= '</Entrega>';
        $linhas .= '<xObs>ICMS ISENTO CFE LIVRO I ART.10, INC IX DO DECRETO DE 37.699/97 DO RICMS.' . "\n";
        if (!empty($faturas)):
            $totimp = 0;
            foreach ($faturas AS $fat):
                $totimp += $fat['valor'];
            endforeach;
            $imposto['municipal'] = $totimp * 0;
            $imposto['federal'] = $totimp * 0.0747;
            $imposto['estadual'] = $totimp * 0.015;
            $totimp = $imposto['municipal'] + $imposto['estadual'] + $imposto['federal'];
            //$linhas .= "\n" . ' Valor Aproximado dos Tributos ' . WS_Money::adjustToView($totimp) . ' (16,06 %) Fonte: IBTP';
            $linhas .= "\n" . ' Valor Aproximado dos Tributos: Federais ' . WS_Money::adjustToView($imposto['federal']) . ' (7,47%), Estaduais ' . WS_Money::adjustToView($imposto['estadual']) . '  (1,5%) e Municipais ' . WS_Money::adjustToView($imposto['municipal']) . ' (0%) conforme disposto na Lei 12.741/12 Fonte: IBPT.';
        endif;
        $linhas .= "\n" . WS_Text::clearSpaces($cte['observacoes']);
        $linhas .= '</xObs>';
        $linhas .= '</compl>';
        $linhas .= '<emit>';
        $linhas .= '<CNPJ>' . WS_Text::clearSpaces(WS_Text::onlyNumber($empresa['documento'])) . '</CNPJ>';
//if (!empty($empresa['inscricao_estadual'])):
        $linhas .= '<IE>' . WS_Text::clearSpaces($empresa['inscricao_estadual']) . '</IE>';
//endif;
        if ($ambiente == 2):
            $linhas .= '<xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome>';
        else:
            $linhas .= '<xNome>' . WS_Text::clearSpaces($empresa['razao_social']) . '</xNome>';
        endif;
        $linhas .= '<xFant>' . WS_Text::clearSpaces($empresa['nome_fantasia']) . '</xFant>';
        $linhas .= '<enderEmit>';
        $linhas .= '<xLgr>' . WS_Text::clearSpaces($empresa['endereco']) . '</xLgr>';
        $linhas .= '<nro>0' . WS_Text::clearSpaces($empresa['numero']) . '</nro>';
        if (!empty($empresa['complemento'])):
            $linhas .= '<xCpl>' . WS_Text::clearSpaces($empresa['complemento']) . '</xCpl>';
        endif;
        $linhas .= '<xBairro>' . WS_Text::clearSpaces($empresa['bairro']) . '</xBairro>';
        $linhas .= '<cMun>' . WS_Text::clearSpaces($empresa['codigo_municipio']) . '</cMun>';
        $linhas .= '<xMun>' . WS_Text::clearSpaces($empresa['municipio']) . '</xMun>';
        $linhas .= '<CEP>' . WS_Text::clearSpaces(WS_Text::onlyNumber($empresa['cep'])) . '</CEP>';
        $linhas .= '<UF>' . WS_Text::clearSpaces($empresa['uf']) . '</UF>';
        $linhas .= '<fone>' . WS_Text::clearSpaces(WS_Text::onlyNumber($empresa['telefone'])) . '</fone>';
        $linhas .= '</enderEmit>';
        $linhas .= '</emit>';

        $linhas .= '<rem>';
        if ($cliente['documento_tipo'] == 1):
            $linhas .= '<CNPJ>' . WS_Text::clearSpaces(WS_Text::onlyNumber($cliente['documento'])) . '</CNPJ>';
        else:
            $linhas .= '<CPF>' . WS_Text::clearSpaces(WS_Text::onlyNumber($cliente['documento'])) . '</CPF>';
        endif;
//if (!empty($cliente['inscricao_estadual'])):
        $linhas .= '<IE>' . WS_Text::clearSpaces($cliente['inscricao_estadual']) . '</IE>';
//endif;
        if ($ambiente == 2):
            $linhas .= '<xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome>';
        else:
            $linhas .= '<xNome>' . WS_Text::clearSpaces($cliente['razao_social']) . '</xNome>';
        endif;
        $linhas .= '<xFant>' . WS_Text::clearSpaces($cliente['nome_fantasia']) . '</xFant>';
        $linhas .= '<fone>' . WS_Text::clearSpaces(WS_Text::onlyNumber($cliente['telefone'])) . '</fone>';
        $linhas .= '<enderReme>';
        $linhas .= '<xLgr>' . WS_Text::clearSpaces($cliente['endereco']['endereco']) . '</xLgr>';
        $linhas .= '<nro>0' . WS_Text::clearSpaces($cliente['endereco']['numero']) . '</nro>';
        if (!empty($cliente['endereco']['complemento'])):
            $linhas .= '<xCpl>' . WS_Text::clearSpaces($cliente['endereco']['complemento']) . '</xCpl>';
        endif;
        $linhas .= '<xBairro>' . WS_Text::clearSpaces($cliente['endereco']['bairro']) . '</xBairro>';
        $linhas .= '<cMun>' . WS_Text::clearSpaces($cliente['endereco']['codigo_municipio']) . '</cMun>';
        $linhas .= '<xMun>' . WS_Text::clearSpaces($cliente['endereco']['municipio']) . '</xMun>';
        $linhas .= '<CEP>' . WS_Text::clearSpaces(WS_Text::onlyNumber($cliente['endereco']['cep'])) . '</CEP>';
        $linhas .= '<UF>' . WS_Text::clearSpaces($cliente['endereco']['uf']) . '</UF>';
        $linhas .= '<cPais>1058</cPais>';
        $linhas .= '<xPais>BRASIL</xPais>';
        $linhas .= '</enderReme>';
//$linhas .= '<infOutros>';
//$linhas .= '<tpDoc>00</tpDoc>';
//$linhas .= '</infOutros>';
        $linhas .= '</rem>';

        if (!empty($expedidor)):
            $linhas .= '<exped>';
            if ($expedidor['documento_tipo'] == 1):
                $linhas .= '<CNPJ>' . WS_Text::clearSpaces(WS_Text::onlyNumber($expedidor['documento'])) . '</CNPJ>';
            else:
                $linhas .= '<CPF>' . WS_Text::clearSpaces(WS_Text::onlyNumber($expedidor['documento'])) . '</CPF>';
            endif;
//if (!empty($expedidor['inscricao_estadual'])):
            $linhas .= '<IE>' . WS_Text::clearSpaces($expedidor['inscricao_estadual']) . '</IE>';
//endif;
            if ($ambiente == 2):
                $linhas .= '<xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome>';
            else:
                $linhas .= '<xNome>' . WS_Text::clearSpaces($expedidor['razao_social']) . '</xNome>';
            endif;
            $linhas .= '<fone>' . WS_Text::clearSpaces(WS_Text::onlyNumber($expedidor['telefone'])) . '</fone>';
            $linhas .= '<enderExped>';
            $linhas .= '<xLgr>' . WS_Text::clearSpaces($expedidor['endereco']['endereco']) . '</xLgr>';
            $linhas .= '<nro>0' . WS_Text::clearSpaces($expedidor['endereco']['numero']) . '</nro>';
            if (!empty($expedidor['endereco']['complemento'])):
                $linhas .= '<xCpl>' . WS_Text::clearSpaces($expedidor['endereco']['complemento']) . '</xCpl>';
            endif;
            $linhas .= '<xBairro>' . WS_Text::clearSpaces($expedidor['endereco']['bairro']) . '</xBairro>';
            $linhas .= '<cMun>' . WS_Text::clearSpaces($expedidor['endereco']['codigo_municipio']) . '</cMun>';
            $linhas .= '<xMun>' . WS_Text::clearSpaces($expedidor['endereco']['municipio']) . '</xMun>';
            $linhas .= '<CEP>' . WS_Text::onlyNumber($expedidor['endereco']['cep']) . '</CEP>';
            $linhas .= '<UF>' . WS_Text::clearSpaces($expedidor['endereco']['uf']) . '</UF>';
            $linhas .= '<cPais>1058</cPais>';
            $linhas .= '<xPais>BRASIL</xPais>';
            $linhas .= '</enderExped>';
            $linhas .= '</exped>';
        endif;

        if (!empty($recebedor)):
            $linhas .= '<receb>';
            if ($recebedor['documento_tipo'] == 1):
                $linhas .= '<CNPJ>' . WS_Text::clearSpaces(WS_Text::onlyNumber($recebedor['documento'])) . '</CNPJ>';
            else:
                $linhas .= '<CPF>' . WS_Text::clearSpaces(WS_Text::onlyNumber($recebedor['documento'])) . '</CPF>';
            endif;
//if (!empty($recebedor['inscricao_estadual'])):
            $linhas .= '<IE>' . WS_Text::clearSpaces($recebedor['inscricao_estadual']) . '</IE>';
//endif;
            if ($ambiente == 2):
                $linhas .= '<xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome>';
            else:
                $linhas .= '<xNome>' . WS_Text::clearSpaces($recebedor['razao_social']) . '</xNome>';
            endif;
            $linhas .= '<fone>' . WS_Text::clearSpaces(WS_Text::onlyNumber($recebedor['telefone'])) . '</fone>';
            $linhas .= '<enderReceb>';
            $linhas .= '<xLgr>' . WS_Text::clearSpaces($recebedor['endereco']['endereco']) . '</xLgr>';
            $linhas .= '<nro>0' . WS_Text::clearSpaces($recebedor['endereco']['numero']) . '</nro>';
            if (!empty($recebedor['endereco']['complemento'])):
                $linhas .= '<xCpl>' . WS_Text::clearSpaces($recebedor['endereco']['complemento']) . '</xCpl>';
            endif;
            $linhas .= '<xBairro>' . WS_Text::clearSpaces($recebedor['endereco']['bairro']) . '</xBairro>';
            $linhas .= '<cMun>' . WS_Text::clearSpaces($recebedor['endereco']['codigo_municipio']) . '</cMun>';
            $linhas .= '<xMun>' . WS_Text::clearSpaces($recebedor['endereco']['municipio']) . '</xMun>';
            $linhas .= '<CEP>' . WS_Text::clearSpaces(WS_Text::onlyNumber($recebedor['endereco']['cep'])) . '</CEP>';
            $linhas .= '<UF>' . WS_Text::clearSpaces($recebedor['endereco']['uf']) . '</UF>';
            $linhas .= '<cPais>1058</cPais>';
            $linhas .= '<xPais>BRASIL</xPais>';
            $linhas .= '</enderReceb>';
            $linhas .= '</receb>';
        endif;

        $linhas .= '<dest>';

        if ($destinatario['documento_tipo'] == 1):
            $linhas .= '<CNPJ>' . WS_Text::clearSpaces(WS_Text::onlyNumber($destinatario['documento'])) . '</CNPJ>';
        else:
            $linhas .= '<CPF>' . WS_Text::clearSpaces(WS_Text::onlyNumber($destinatario['documento'])) . '</CPF>';
        endif;
//if (!empty($destinatario['inscricao_estadual'])):
        $linhas .= '<IE>' . WS_Text::clearSpaces(WS_Text::onlyNumber($destinatario['inscricao_estadual'])) . '</IE>';
//endif;
        if ($ambiente == 2):
            $linhas .= '<xNome>CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL</xNome>';
        else:
            $linhas .= '<xNome>' . WS_Text::clearSpaces($destinatario['razao_social']) . '</xNome>';
        endif;
        $linhas .= '<fone>' . WS_Text::clearSpaces(WS_Text::onlyNumber($destinatario['telefone'])) . '</fone>';
        $linhas .= '<enderDest>';
        $linhas .= '<xLgr>' . WS_Text::clearSpaces($destinatario['endereco']['endereco']) . '</xLgr>';
        $linhas .= '<nro>0' . WS_Text::clearSpaces($destinatario['endereco']['numero']) . '</nro>';
        if (!empty($destinatario['endereco']['complemento'])):
            $linhas .= '<xCpl>' . WS_Text::clearSpaces($destinatario['endereco']['complemento']) . '</xCpl>';
        endif;
        $linhas .= '<xBairro>' . WS_Text::clearSpaces($destinatario['endereco']['bairro']) . '</xBairro>';
        $linhas .= '<cMun>' . WS_Text::clearSpaces($destinatario['endereco']['codigo_municipio']) . '</cMun>';
        $linhas .= '<xMun>' . WS_Text::clearSpaces($destinatario['endereco']['municipio']) . '</xMun>';
        $linhas .= '<CEP>' . WS_Text::clearSpaces(WS_Text::onlyNumber($destinatario['endereco']['cep'])) . '</CEP>';
        $linhas .= '<UF>' . WS_Text::clearSpaces($destinatario['endereco']['uf']) . '</UF>';
        $linhas .= '<cPais>1058</cPais>';
        $linhas .= '<xPais>BRASIL</xPais>';
        $linhas .= '</enderDest>';
        $linhas .= '</dest>';

        $linhas .= '<vPrest>';
        $linhas .= '<vTPrest>' . WS_Text::clearSpaces($fatura['total']) . '</vTPrest>';
        $linhas .= '<vRec>' . WS_Text::clearSpaces($fatura['total']) . '</vRec>';
        $linhas .= '<Comp>';
        $linhas .= '<xNome>EFLUENTE</xNome>';
        $linhas .= '<vComp>' . WS_Text::clearSpaces($fatura['total']) . '</vComp>';
        $linhas .= '</Comp >';
        $linhas .= '</vPrest>';
        $linhas .= '<imp>';
        $linhas .= '<ICMS>';
        $linhas .= '<ICMSSN>';
        $linhas .= '<indSN>1</indSN>';
        $linhas .= '</ICMSSN>';
        $linhas .= '</ICMS>';
        if (isset($totimp)):
            $linhas .= '<vTotTrib>' . number_format($totimp, 2, '.', '') . '</vTotTrib>';
        endif;
//$linhas .= '<infAdFisco>ICMS ISENTO CFE LIVRO I ART.10, INC IX DO DECRETO DE 37.699/97 DO RICMS</infAdFisco>';
        $linhas .= '</imp>';
        $linhas .= '<infCTeNorm>';
        $linhas .= '<infCarga>';
        if (!empty($cte['valor_carga'])):
            $linhas .= '<vCarga>' . number_format($cte['valor_carga'], 2, '.', '') . '</vCarga>';
        else:
            $linhas .= '<vCarga>0.00</vCarga>';
        endif;


        $linhas .= '<proPred>EFLUENTE</proPred>';
        $linhas .= '<infQ>';
        $linhas .= '<cUnid>00</cUnid>';
        $linhas .= '<tpMed>LITRAGEM</tpMed>';
        $linhas .= '<qCarga>' . WS_Text::clearSpaces($cte['quantidade']) . '</qCarga>';
        $linhas .= '</infQ>';
        $linhas .= '</infCarga>';
        $linhas .= '<infDoc>';

        if (!empty($cte['nfe_chave'])):
            $linhas .= '<infNFe>';
            $linhas .= '<chave>' . $cte['nfe_chave'] . '</chave>';
            if (!empty($cte['nfe_pin'])):
                $linhas .= '<PIN>' . $cte['nfe_pin'] . '</PIN>';
            endif;
            if (!empty($cte['nfe_data_emissao'])):
                $linhas .= '<dPrev>' . $cte['nfe_data_emissao'] . '</dPrev>';
            endif;
            $linhas .= '</infNFe>';
        else:
            $linhas .= '<infOutros>';
            if (!empty($cte['doc_tipo'])):
                $linhas .= '<tpDoc>' . $cte['doc_tipo'] . '</tpDoc>';
                $linhas .= '<descOutros>' . $cte['doc_descricao'] . '</descOutros>';
                $linhas .= '<nDoc>' . $cte['doc_numero'] . '</nDoc>';
                $linhas .= '<vDocFisc>' . number_format($cte['doc_valor'], 2, '.', '') . '</nDoc>';
                $linhas .= '<dEmi>' . $cte['doc_data_emissao'] . '</dEmi>';
                $linhas .= '<dPrev>' . $cte['doc_data_emissao'] . '</dPrev>';
            else:
                $linhas .= '<tpDoc>99</tpDoc>';
                $linhas .= '<descOutros>Outros Documentos</descOutros>';
                $linhas .= '<nDoc>0</nDoc>';
                $linhas .= '<dEmi>' . WS_Text::clearSpaces(date('Y-m-d')) . '</dEmi>';
                $linhas .= '<dPrev>' . WS_Text::clearSpaces(date('Y-m-d')) . '</dPrev>';
            endif;
            $linhas .= '</infOutros>';
        endif;


        $linhas .= '</infDoc>';
        $linhas .= '<seg>';
        $linhas .= '<respSeg>4</respSeg>';
        $linhas .= '</seg>';
        $linhas .= '<infModal versaoModal = "2.00">';
        $linhas .= '<rodo>';
        $linhas .= '<RNTRC>' . WS_Text::clearSpaces($cte['rtnrc']) . '</RNTRC>';
        $linhas .= '<dPrev>' . WS_Text::clearSpaces(date('Y-m-d')) . '</dPrev>';
        $linhas .= '<lota>0</lota>';
        $linhas .= '</rodo>';
        $linhas .= '</infModal>';

//verificar tpMed, nos componentes do valor tem que aparecer Efluente e valor, situação tributária

        if (!empty($faturas)):
            $linhas .= '<cobr>';
            $linhas .= '<fat>';
            $linhas .= '<nFat>00' . WS_Text::clearSpaces($cte['id']) . '</nFat>';
            $linhas .= '<vOrig>' . WS_Text::clearSpaces($fatura['total']) . '</vOrig>';
            $linhas .= '<vLiq>' . WS_Text::clearSpaces($fatura['total']) . '</vLiq>';
            $linhas .= '</fat>';
            include("BoletoItau/functions.php");
            foreach ($faturas AS $fatura):
                $boleto = $ContasReceberModel->buscarParaBoleto($fatura['id']);
                if (!empty($boleto['id'])):
                    require('BoletoItau/boleto.php');
                    if (!empty($dadosboleto['linha_digitavel'])):
                        $linhas .= '<dup>';
                        $linhas .= '<nDup>' . WS_Text::clearSpaces($dadosboleto['linha_digitavel']) . '</nDup>';
                        $linhas .= '<dVenc>' . WS_Text::clearSpaces($fatura['data_vencimento']) . '</dVenc>';
                        $linhas .= '<vDup>' . WS_Text::clearSpaces($fatura['valor']) . '</vDup>';
                        $linhas .= '</dup>';
                    endif;
                endif;
            endforeach;
            $linhas .= '</cobr>';
        endif;

        $linhas .= '</infCTeNorm>';
        $linhas .= '</infCte>';
        $linhas .= '</CTe>';
        return $linhas;
    }

    public function relatorio($data) {
        $consulta = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('cte' => 'ctes_acqualife'), array('*'))
                ->joinInner(array('c' => 'clientes'), 'c.id = cte.cliente_id', array('cliente' => 'razao_social'))
                ->joinLeft(array('cr' => 'contas_receber'), 'cr.cte_acqualife_id = cte.id', array('total' => 'SUM(cr.valor-cr.valor_retido)'))
                ->order('cte.data ASC')
                ->order('cte.id ASC')
                ->group('cte.id');

        if (!empty($data['data_inicial'])):
            $consulta->where('cte.data >= ?', WS_Date::adjustToDb($data['data_inicial']));
        endif;
        if (!empty($data['data_final'])):
            $consulta->where('cte.data <= ?', WS_Date::adjustToDb($data['data_final']));
        endif;
        if (!empty($data['cliente_id'])):
            $consulta->where('c.id = ?', $data['cliente_id']);
        endif;

        $itens = $consulta->query()->fetchAll();
        return $itens;
    }

    public function getSumByPeriod($dataInicial, $dataFinal, $empresa_id = '') {
        $sql = $this->_db->select()
                ->setIntegrityCheck(false)
                ->from(array('c' => 'ctes_acqualife'), array(''))
                ->joinInner(array('cr' => 'contas_receber'), 'cr.cte_acqualife_id = c.id', array('faturamento' => 'SUM(cr.valor)'))
                ->where('c.data >= ?', $dataInicial)
                ->where('c.data <= ?', $dataFinal);
        if (!empty($empresa_id)):
            $sql->where('cr.empresa_id = ?', $empresa_id);
        endif;
        return $sql->query()->fetch();
    }

}
