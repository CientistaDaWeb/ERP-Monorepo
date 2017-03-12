<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa				  |
// | 																	  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Ita�: Glauber Portella		                  |
// +----------------------------------------------------------------------+


$codigobanco = "341";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);

//valor tem 10 digitos, sem virgula
$valor = formata_numero($dadosboleto["valor_boleto"], 10, 0, "valor");
//agencia � 4 digitos
$agencia = formata_numero($dadosboleto["agencia"], 4, 0);
//conta � 5 digitos + 1 do dv
$conta = formata_numero($dadosboleto["conta"], 5, 0);
$conta_dv = formata_numero($dadosboleto["conta_dv"], 1, 0);
//carteira 175
$carteira = $dadosboleto["carteira"];
//nosso_numero no maximo 8 digitos
$nnum = formata_numero($dadosboleto["nosso_numero"], 8, 0);

$codigo_barras = $codigobanco . $nummoeda . $fator_vencimento . $valor . $carteira . $nnum . modulo_10($agencia . $conta . $carteira . $nnum) . $agencia . $conta . modulo_10($agencia . $conta) . '000';
// 43 numeros para o calculo do digito verificador
$dv = digitoVerificador_barra($codigo_barras);
// Numero para o codigo de barras com 44 digitos
$linha = substr($codigo_barras, 0, 4) . $dv . substr($codigo_barras, 4, 43);

$nossonumero = $carteira . '/' . $nnum . '-' . modulo_10($agencia . $conta . $carteira . $nnum);
$agencia_codigo = $agencia . " / " . $conta . "-" . modulo_10($agencia . $conta);

$dadosboleto["codigo_barras"] = $linha;
$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha); // verificar
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;


?>