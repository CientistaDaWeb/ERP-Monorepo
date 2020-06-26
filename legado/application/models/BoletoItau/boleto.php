<?php

// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponivel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Itaú: Glauber Portella                        |
// +----------------------------------------------------------------------+
// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
// DADOS DO BOLETO PARA O SEU CLIENTE
//$dias_de_prazo_para_pagamento = 5;
$dadosboleto = null;
$taxa_boleto = 0.00;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$data_venc = WS_Date::adjustToView($boleto['data_vencimento']);
//$valor_cobrado = "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
//$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_cobrado = $boleto['valor'] - $boleto['valor_retido'];
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $boleto['id'];  // Nosso numero - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = $boleto['id']; // Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $boleto['cliente'];
$dadosboleto["endereco1"] = $boleto['cliente_endereco'] . ', ' . $boleto['cliente_numero'] . ' - ' . $boleto['cliente_bairro'];
$dadosboleto["endereco2"] = $boleto['cliente_cidade'] . ' / ' . $boleto['cliente_uf'] . ' ' . $boleto['cliente_cep'];

$mora = number_format($valor_cobrado * 0.00033, 2, ',', '.');
if ($boleto['cliente_id'] == 13 || $boleto['cliente_id'] == 362):
    $multa = number_format($valor_cobrado * 0.05, 2, ',', '.');
else:
    $multa = number_format($valor_cobrado * 0.02, 2, ',', '.');
endif;


// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = '';
$dadosboleto["demonstrativo2"] = '';
$dadosboleto["demonstrativo3"] = '';
$dadosboleto["instrucoes1"] = '- APOS VENCIMENTO COBRAR R$ ' . $mora . ' POR DIA DE ATRASO';
$dadosboleto["instrucoes2"] = '- APOS VENCIMENTO COBRAR MULTA DE R$ ' . $multa;
$dadosboleto["instrucoes3"] = '- PROTESTAR APOS 10 DIAS CORRIDOS DO VENCIMENTO';
$dadosboleto["instrucoes4"] = '- ' . $boleto['descricao'];
$dadosboleto["instrucoes5"] = '';

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS DA SUA CONTA - ITAÚ
$contaCorrente = explode('-', $boleto['conta_corrente']);
if (!is_array($contaCorrente)):
    $contaCorrente = array('0', '0');
endif;
$dadosboleto["agencia"] = $boleto['agencia']; // Num da agencia, sem digito
$dadosboleto["conta"] = $contaCorrente[0]; // Num da conta, sem digito
$dadosboleto["conta_dv"] = $contaCorrente[1];  // Digito do Num da conta
// DADOS PERSONALIZADOS - ITAÚ
$dadosboleto["carteira"] = $boleto['carteira'];  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
// SEUS DADOS
$dadosboleto["identificacao"] = "";
$dadosboleto["cpf_cnpj"] = $boleto['empresa_documento'];
$dadosboleto["endereco"] = $boleto['empresa_endereco'] . ', ' . $boleto['empresa_numero'] . ' - ' . $boleto['empresa_bairro'];
$dadosboleto["cidade_uf"] = $boleto['empresa_cidade'] . ' / ' . $boleto['empresa_uf'];
$dadosboleto["cedente"] = $boleto['empresa'];

// NÃO ALTERAR!
include("BoletoItau/funcoes.php");
?>
