<?php

class CnabItau_Model {

    public $_empresa;
    public $_faturas = array();
    public $_sequencial;

    public function __construct() {
        $this->_sequencial = 1;
    }

    public function criaArquivo($faturas, $forma_pagamento_id) {

        $EmpresaModel = new Empresas_Model();
        $empresa = $EmpresaModel->buscarDadosPorFormaPagamento($forma_pagamento_id);

        $RemessasModel = new Remessas_Model();

        $sequencial = $RemessasModel->buscaSequencial();

        $caminho = UPLOAD_PATH . 'remessas/';
        $arquivo = 'C' . date('ymd') . $sequencial . '.txt';


        $dados = array(
            'banco_id' => $empresa['banco_id'],
            'data_emissao' => date('Y-m-d'),
            'arquivo' => $arquivo
        );
        $acao = $RemessasModel->_actions['add'];
        $tableName = $RemessasModel->_db->getTableName();

        $id = $RemessasModel->_db->insere($dados, $acao, $tableName);

        $linha = array();

        $linha[] = $this->criaHeader($empresa);

        unlink($caminho . $arquivo);
        foreach ($faturas AS $fatura):
            $linha[] = $this->criaFatura($fatura, $empresa, $id);
        endforeach;
        $linha[] = $this->criaFooter();
        $linha[] = '';

        $fp = fopen($caminho . $arquivo, 'w');
        fwrite($fp, implode(chr(13) . chr(10), $linha));
        fclose($fp);
        return $id;
    }

    public function criaHeader($empresa) {
        $linha = '0'; // Identificação do registro header (1)[0]{1}
        $linha.= '1'; // Tipo de Operação - Remessa (1)[1]{2}
        $linha.= $this->completaCampo('REMESSA', 7, ' '); // Identificação por extenso do movimento (7)[REMESSA]{3-9}
        $linha.= '01'; // Identificação do tipo de serviço (2)[01]{10-11}
        $linha.= $this->completaCampo('COBRANCA', 15, ' ', 'l'); // Identificação por extenso do tipo do seviço (15)[COBRANCA]{12-26}
        $linha.= $this->completaCampo($empresa['agencia'], 4, '0'); // Agência Mantenedora da conta (04){27-30}
        $linha.= '00'; // Complemento do Registro (2)[00]{31-32}
        $linha.= $this->completaCampo($empresa['conta_corrente'], 6, '0'); // Número da conta corrente da emprea (5){33-37}
        $linha.= $this->completaCampo('', 8, ' '); // Complemento do registro (8){38-45}
        $linha.= $this->completaCampo($empresa['razao_social'], 30, ' ', 'l'); // Nome por extenso da Empresa (30){46-75}
        $linha.= '341'; // Número do banco na câmara de compensação (3)[341]{76-78}
        $linha.= 'BANCO ITAU SA  '; // Nome por extenso do banco cobrador (15)[BANCO ITAU SA  ]{79-93}
        $linha.= date('dmy'); // Data de geração do Arquivo (6)[DDMMYY]{94-99}
        $linha.= $this->completaCampo('S202C', 294, ' '); // Complemento do Registro [294]{100-393}
        $linha.= $this->completaCampo($this->_sequencial, 6, '0'); // Número sequencial do registro no arquivo (6){395-400}
        $this->_sequencial++;
        return $linha;
    }

    public function criaFatura($conta_id, $empresa, $remessa_id) {
        $ContasReceberModel = new ContasReceber_Model();
        $fatura = $ContasReceberModel->buscarDadosCnab($conta_id);

        $ZD = new Zend_Date($fatura['data_vencimento']);
        $ZD2 = new Zend_Date($fatura['created']);

        $ClientesEndereco = new ClientesEnderecos_Model();
        $cliente_endereco = $ClientesEndereco->buscarPorCliente($fatura['cliente_id']);
        $cliente_endereco = $cliente_endereco[0];

        $linha = '1'; // Identificação do registro (1)[1]{1}
        $linha .= '02'; // Tipo de Inscrição da Empresa (2)[02]{2-3}
        $linha .= $this->completaCampo($empresa['documento'], 14, ' '); // Número da inscrição da empresa (14){4-17}
        $linha .= $this->completaCampo($empresa['agencia'], 4, '0'); // Agência mantenedora da conta (4){18-21}
        $linha .= '00'; // Complemento de registro (2)[00]{22-23}
        $linha .= $this->completaCampo($empresa['conta_corrente'], 6, '0'); // Número da conta correte da empresa (6){24-29}
        $linha .= $this->completaCampo('', 4, ' '); // Complemento de registros (4)[    ]{30-33}
        $linha .= $this->completaCampo('', 4, ' '); // Código instrução/alegação a ser cancelada(4){34-37}
        $linha .= $this->completaCampo('', 25, ' '); // Identificação do título na empresa (25){38-62}
        $linha .= $this->completaCampo($fatura['id'], 8, '0'); // Identificação do título no banco(8){63-70}
        $linha .= $this->completaCampo('', 13, '0'); // Quantidade de moeda variável (13){71-83}
        $linha .= $this->completaCampo($empresa['carteira'], 3, '0'); // Número da carteira no banco(3){84-86}
        $linha .= $this->completaCampo('', 21, ' '); // Identificação da Operação no banco (21){87-107}
        $linha .= 'I'; // Código da Carteira (1){108}
        $linha .= '01'; // Identificação da ocorrencia (2){109-110}
        $linha .= $this->completaCampo($fatura['id'], 10, ' ', 'l'); // Número do documento de cobrança (10){111-120}
        $linha .= $ZD->toString('ddMMYY'); // data de vencimento (6)[ddmmyy]{121-126}
        $linha .= $this->completaCampo(number_format(($fatura['valor'] - $fatura['valor_retido']), '2', '', ''), 13, '0'); // Valor nominal do titulo (13){127-139}
        $linha .= '341'; // Nº do banco na câmara de compensação (3)[341]{140-142}
        $linha .= $this->completaCampo('', 5, '0'); // Agência onde o título será cobrado (5){143-147}
        $linha .= '01'; // Espécie do título (2){148-149}
        $linha .= 'N'; // Identificação de título aceito ou não aceito (1)[N|A]{150}
        $linha .= $ZD2->toString('ddMMYY'); // Data de emissão do titulo (6)[ddmmyy]{151-156}
        $linha .= '09'; // 1ª Instrução de cobrança (2){157-158}
        $linha .= '00'; // 2ª Instrução de cobrança (2){159-160}
        $linha .= $this->completaCampo(number_format((($fatura['valor'] - $fatura['valor_retido']) * 0.00033), '2', '', ''), 13, '0'); // Valor de mora por dia de atraso (13){161-173}
        $linha .= '000000'; // Data limite para concessão de desconto(6){174-179}
        $linha .= $this->completaCampo('', 13, '0'); // Valor do desconto a ser concedido (13){180-192}
        $linha .= $this->completaCampo('', 13, '0'); // Valor do i.o.f recolhido p/ notas seguro (13){193-205}
        $linha .= $this->completaCampo('', 13, '0'); // Valor do abatimento a ser concedido (13){206-218}
        $linha .= $this->completaCampo(($fatura['documento_tipo'] % 2) + 1, 2, '0'); // Indicação do tipo de inscrição do sacado (2)[]{219-220}
        $linha .= $this->completaCampo($fatura['documento'], 14, ' ', 'l'); // nº de inscrição do sacado (14){221-234}
        $linha .= $this->completaCampo($fatura['razao_social'], 30, ' ', 'l'); // Nome do Sacado (30){235-264}
        $linha .= $this->completaCampo('', 10, ' '); // Complemento do registro (10){265-274}
        $linha .= $this->completaCampo($cliente_endereco['endereco'] . ' ' . $cliente_endereco['numero'] . ' ' . $cliente_endereco['complemento'], 40, ' ', 'l'); // Rua número e complemento do sacado (40){275-314}
        $linha .= $this->completaCampo($cliente_endereco['bairro'], 12, ' ', 'l'); // Bairro do sacado (12){315-326}
        $linha .= $this->completaCampo($cliente_endereco['cep'], 8, ' '); // Cep do sacado (8){327-334}
        $linha .= $this->completaCampo($cliente_endereco['cidade'], 15, ' ', 'l'); // Cidade do sacado (15){335-349}
        $linha .= $this->completaCampo($cliente_endereco['uf'], 2, ' '); // Estado do sacado (2){350-351}
        $linha .= $this->completaCampo('', 30, ' '); // Nome do sacador ou avalista (30){352-381}
        $linha .= $this->completaCampo('', 4, ' '); // Complemento do registro (4){382-385}
        $linha .= $this->completaCampo('', 6, '0'); // Data de Mora (6)[ddmmyy]{386-391}
        $linha .= '10'; // Quantidade de dias (2){392-393}
        $linha .= ' '; // Complemento de registro (1){394}
        $linha .= $this->completaCampo($this->_sequencial, 6, '0'); // Número sequencial do registro no arquivo (6){395-400}
        $this->_sequencial++;

        $data['remessa_id'] = $remessa_id;
        $data['id'] = $fatura['id'];
        $acao = $ContasReceberModel->_actions['update'];
        $tableName = $ContasReceberModel->_db->getTableName();

        $ContasReceberModel->_db->atualiza($data, $acao, $tableName);

        return $linha;
    }

    public function criaFooter() {
        $linha = '9'; // Identificação do registro trailer (1)
        $linha .= $this->completaCampo('', 393, ' '); // compelmento do registro (393)
        $linha .= $this->completaCampo($this->_sequencial, 6, '0'); // Número sequencial do registro no arquivo (6)
        return $linha;
    }

    public function leRetorno($arquivo, $caminho) {
        $fp = fopen($caminho . $arquivo, 'r');
        while (!feof($fp)) {
            $linhas[] = fgets($fp, 4096);
        }
        fclose($fp);

        $total = count($linhas);
        if ($total > 2):

            $cabecalho = $this->leCabecalho($linhas[0]);

            $RetornosModel = new Retornos_Model();
            $dados['arquivo'] = $arquivo;
            $dados['banco_id'] = $cabecalho['banco_id'];
            $dados['data_recebimento'] = $cabecalho['data_recebimento'];
            $acao = $RetornosModel->getOption('actions', 'add');
            $tableName = $RetornosModel->_db->getTableName();
            $retorno_id = $RetornosModel->_db->insere($dados, $acao, $tableName);

            for ($i = 1; $i < $total; $i++) {
                $this->darBaixa($linhas[$i], $retorno_id);
            }

            return $retorno_id;
        endif;
    }

    public function leCabecalho($linha) {
        if ($this->buscaCampo($linha, 3, 7) == 'RETORNO'):
            $retorno['agencia'] = $this->buscaCampo($linha, 27, 4);
            $retorno['conta_corrente'] = $this->buscaCampo($linha, 33, 5) . '-' . $this->buscaCampo($linha, 38, 1);

            $BancosModel = new Bancos_Model();
            $banco = $BancosModel->buscarPorConta($retorno['agencia'], $retorno['conta_corrente']);
            if (!empty($banco['id'])):
                $retorno['banco_id'] = $banco['id'];
                $retorno['data_recebimento'] = '20' . $this->buscaCampo($linha, 118, 2) . '-' . $this->buscaCampo($linha, 116, 2) . '-' . $this->buscaCampo($linha, 114, 2);
                return $retorno;
            else:
                echo 'Erro ao identificar o banco!';
            endif;
        else:
            echo 'Erro ao ler o arquivo';
        endif;
    }

    public function darBaixa($linha, $retorno_id) {
        $ContasReceberModel = new ContasReceber_Model();

        $conta = $ContasReceberModel->find($this->buscaCampo($linha, 63, 8));

        $valorDaConta = $this->buscaCampo($linha, 153, 11) . '.' . $this->buscaCampo($linha, 164, 2);

        if ($valorDaConta == ($conta['valor'] - $conta['valor_retido'])):
            $WM = new WS_Money();
            $depositado = $this->buscaCampo($linha, 254, 11) . '.' . $this->buscaCampo($linha, 265, 2);
            //$taxa = $this->buscaCampo($linha, 176, 11) . '.' . $this->buscaCampo($linha, 187, 2);
            $multa = $this->buscaCampo($linha, 267, 11) . '.' . $this->buscaCampo($linha, 278, 2);
            $desconto = $this->buscaCampo($linha, 241, 11) . '.' . $this->buscaCampo($linha, 252, 2);
            $total = $valorDaConta + $multa - $desconto;

            $dados['retorno_id'] = $retorno_id;
            $dados['valor_pago'] = WS_Money::adjustToDb($total);
            $dados['id'] = $this->buscaCampo($linha, 63, 8);
            $dados['data_pagamento'] = '20' . $this->buscaCampo($linha, 300, 2) . '-' . $this->buscaCampo($linha, 298, 2) . '-' . $this->buscaCampo($linha, 296, 2);

            if ($this->buscaCampo($linha, 298, 2) != '  ') :
                $acao = $ContasReceberModel->getOption('actions', 'update');
                $tableName = $ContasReceberModel->_db->getTableName();
                $ContasReceberModel->_db->atualiza($dados, $acao, $tableName);
            endif;
        endif;
    }

    public function completaCampo($valor = '', $ncasas, $preenchimento, $posicao = 'r') {
        if (!empty($valor)):
            $valor = trim($valor);
            $valor = WS_Text::withoutAccents($valor);
            $valor = str_replace('-', '', $valor);
            $valor = str_replace('.', '', $valor);
            $valor = str_replace('/', '', $valor);
            $valor = strtoupper($valor);
        endif;
        $var = '';
        for ($i = 0; $i < $ncasas; $i++) :
            $var = $preenchimento . $var;
        endfor;
        if ($posicao == 'r'):
            $var = substr($var . $valor, -$ncasas);
        else:
            $var = substr($valor . $var, 0, $ncasas);
        endif;
        return $var;
    }

    public function buscaCampo($var, $inicio, $ncasas) {
        return substr($var, $inicio - 1, $ncasas);
    }

}
