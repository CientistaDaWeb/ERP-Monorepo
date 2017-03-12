<!DOCTYPE HTML PUBLIC '-//W3C//Dtd HTML 4.0 transitional//EN'>
<html>
    <head>
        <title>Boleto Acquasana</title>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <meta name="Generator" content="Projeto BoletoPHP - www.boletophp.com.br - Licença GPL" />
        <style type="text/css">
            body, html{margin: 0; padding: 0}
            .cp { font: bold 10px; color: black}
            .ti { font: 9px; }
            .ld { font: bold 15px; color: #000000}
            .ct { FONT: 9px Arial; COLOR: #000033}
            .cn { font-size: 9px; COLOR: black }
            .bc { font: bold 20px; color: #000000 }
            .ld2 { font: bold 12px; color: #000000 }
            body *{font-family: 'garuda' !important;}
        </style>
        <link href="/css/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body text="#000000" bgColor="#ffffff" topmargin="0" rightmargin="0">
        <?php
        if ($mostra_pesquisa):
            ?>
            <link href="/css/clear.css" media="screen" rel="stylesheet" type="text/css" />
            <link href="/css/fluid_grid.css" media="screen" rel="stylesheet" type="text/css" />
            <link href="/css/style.css"  media="screen" rel="stylesheet" type="text/css" />
            <link href="/css/erp.css" media="screen" rel="stylesheet" type="text/css" />
            <link href="/css/light/jquery-ui-1.8.23.custom.css" media="screen" rel="stylesheet" type="text/css" />
            <script src="/js/jquery-1.8.0.min.js"></script>
            <script src="/js/jquery-ui-1.8.23.custom.min.js"></script>
            <script>
                $(function() {
                    $('#pesquisaSatisfacao').dialog({
                        'modal': true,
                        'width': 600,
                        show: "slide",
                        hide: "slide",
                    });
                    $('#fechaModal').click(function() {
                        $('#pesquisaSatisfacao').dialog('close');
                    });
                });
            </script>
            <div class="hidden">
                <div class="modal" title="Pesquisa de Satisfação" id="pesquisaSatisfacao">
                    <p>Com o objetivo de aprimorar e melhorar a prestação dos nossos serviços e orientar nossas ações para uma melhoria contínua, contamos com a sua valiosa colaboração, respondendo o questionário abaixo.</p>
                    <br /><br />
                    <form method="post" action="" class="PesquisaSatisfacaoForm formulario" enctype="application/x-www-form-urlencoded" id="PesquisaSatisfacaoForm">
                        <dl class="zend_form">
                            <input type="hidden" id="id" value="" name="id">
                            <input type="hidden" id="certificado_id" value="<?php echo $certificado_id; ?>" name="certificado_id">
                            <dt id="atendimento_telefone-label"><label class="required" for="atendimento_telefone">Atendimento ao telefone, como foi a:</label></dt>
                            <dd id="atendimento_telefone-element">
                                <div class="respostas">
                                    <p><label><input type="radio" name="atendimento_telefone" value="MS" />Muito Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_telefone" value="S" />Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_telefone" value="PS" />Pouco Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_telefone" value="I" />Insatisfeito</label></p>
                                </div>
                                <p class="description">Cordialidade, clareza nas instruções,disponibilidade e agilidade dos atendentes</p>
                            </dd>
                            <div class="clear"></div>
                            <br />
                            <dt id="atendimento_coleta-label"><label class="required" for="atendimento_coleta">Atendimento durante a coleta, como foi nos quesitos:</label></dt>
                            <dd id="atendimento_coleta-element">
                                <div class="respostas">
                                    <p><label><input type="radio" name="atendimento_coleta" value="MS" />Muito Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_coleta" value="S" />Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_coleta" value="PS" />Pouco Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_coleta" value="I" />Insatisfeito</label></p>
                                </div>
                                <p class="description">Habilidade do coletor; Confiabilidade; limpeza e organização; uso de Epis; instruções fornecidas ao cliente</p>
                            </dd>
                            <div class="clear"></div>
                            <br />
                            <dt id="documentacao-label"><label class="required" for="documentacao">Documentações, como avalia as documentações fornecidas:</label></dt>
                            <dd id="documentacao-element">
                                <div class="respostas">
                                    <p><label><input type="radio" name="documentacao" value="MS" />Muito Satisfeito</label></p>
                                    <p><label><input type="radio" name="documentacao" value="S" />Satisfeito</label></p>
                                    <p><label><input type="radio" name="documentacao" value="PS" />Pouco Satisfeito</label></p>
                                    <p><label><input type="radio" name="documentacao" value="I" />Insatisfeito</label></p>
                                </div>
                                <p class="description">MTRs; certificados; relatórios de coleta; boletos, licenças.</p>
                            </dd>
                            <div class="clear"></div>
                            <br />
                            <dt id="atendimento_servico-label"><label class="required" for="atendimento_servico">Atendimento pós prestação de serviço, como avalia os quesitos:</label></dt>
                            <dd id="atendimento_servico-element">
                                <div class="respostas">
                                    <p><label><input type="radio" name="atendimento_servico" value="MS" />Muito Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_servico" value="S" />Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_servico" value="PS" />Pouco Satisfeito</label></p>
                                    <p><label><input type="radio" name="atendimento_servico" value="I" />Insatisfeito</label></p>
                                </div>
                                <p class="description">Retorno sobre a coleta; esclarecimentos fornecidos; conferências; controle de periodicidade da coleta</p>
                            </dd>
                            <div class="clear"></div>
                            <br />
                            <dt id="recomendaria-label"><label class="required" for="recomendaria">Você recomendaria a Acquasana Transportes de efluentes?</label></dt>
                            <dd id="recomendaria-element">
                                <p><label><input type="radio" name="recomendaria" value="S" />Sim</label></p>
                                <p><label><input type="radio" name="recomendaria" value="N" />Não</label></p>
                            </dd>
                            <br />
                            <dt id="observacoes-label"><label class="optional" for="observacoes">Abaixo escreva suas sugestões ou observações sobre nossa empresa. Sinta-se bem à vontade para expor sua opinião, a Acquasana agradece sua contribuição.</label></dt>
                            <dd id="observacoes-element">
                                <textarea cols="80" rows="5" class="ui-corner-all border" id="observacoes" name="observacoes"></textarea></dd>
                            <button class="btEnviar" value="Enviar Pesquisa" type="submit" id="salvar" name="salvar">Enviar Pesquisa</button>
                    </form>
                    <a class="float right" href="javascript:void(0);" id="fechaModal">pular</a>
                </div>
            </div>
            <?php
        endif;
        if (!empty($boletos)):
            $i = 0;
            foreach ($boletos AS $boleto):
                require('BoletoItau/boleto.php');
                if ($i != 0):
                    ?>
                    <div style="page-break-before: always;"></div>
                    <?php
                endif;
                $i++;
                if (!isset($escondeinfo)):
                    ?>
                    <table width="666" cellspacing="0" cellpadding="0" border="0" class="hidden">
                        <tr>
                            <td valign="top" class="cp">
                                <div align="center">Instruções de Impressão</div>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" class="cp">
                                <div align="left">
                                    <ul>
                                        <li>Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).</li>
                                        <li>Utilize folha A4 (210 x 297 mm) e margens mínimas à esquerda e à direita do formulário.</li>
                                        <li>Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.</li>
                                        <li>Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela.</li>
                                        <li>Caso tenha problemas ao imprimir, copie a sequencia numérica abaixo e pague no caixa eletrônico ou no internet banking:<br><br>
                                            <span class="ld2">
                                                &nbsp;&nbsp;&nbsp;&nbsp;Linha Digitável: &nbsp;<?php echo $dadosboleto["linha_digitavel"] ?><br />
                                                &nbsp;&nbsp;&nbsp;&nbsp;Valor: &nbsp;&nbsp;R$ <?php echo $dadosboleto["valor_boleto"] ?><br />
                                            </span></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <table cellspacing="0" cellpadding="0" width="666" border="0">
                        <tobdy>
                            <tr>
                                <td class="ct" width="666"><img height="1" src="/images/boletos/6.png" width="665" border="0"></td>
                            </tr>
                            <tr><td class="ct" width="666">
                                    <div align="right"><b class="cp">Recibo do Sacado</b></div>
                                </td>
                            </tr>
                            </tbody>
                    </table>
                    <table width="666" cellspacing="5" cellpadding="0" border="0">
                        <tr>
                            <td width="41"></td>
                        </tr>
                    </table>
                    <table width="666" cellspacing="5" cellpadding="0" border="0" align="default">
                        <tr>
                            <td width="41"><img src="/images/logos/<?php echo $boleto['logomarca']; ?>" height="60" /></td>
                            <td class="ti" width="455"><?php echo $dadosboleto["identificacao"]; ?> <?php echo isset($dadosboleto["cpf_cnpj"]) ? "<br />" . $dadosboleto["cpf_cnpj"] : '' ?><br />
                                <?php echo $dadosboleto["endereco"]; ?><br />
                                <?php echo $dadosboleto["cidade_uf"]; ?><br />
                            </td>
                            <td align="right" width="150" class="ti">&nbsp;</td>
                        </tr>
                    </table>
                    <br />
                <?php endif; ?>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tr>
                        <td class="cp" width="150"><span class="campo"><img src="/images/boletos/logoitau.jpg" width="150" height="40" border="0"></span></td>
                        <td width="3" valign="bottom"><img height="22" src="/images/boletos/3.png" width="2" border="0"></td>
                        <td class="cpt" width="58" valign="bottom"><div align=center><font class="bc"><?php echo $dadosboleto["codigo_banco_com_dv"] ?></font></div></td>
                        <td width="3" valign="bottom"><img height="22" src="/images/boletos/3.png" width="2" border="0"></td>
                        <td class="ld" align="right" width="453" valign="bottom"><span class="ld"><span class="campotitulo"><?php echo $dadosboleto["linha_digitavel"] ?></span></span></td>
                    </tr>
                    <tbody>
                        <tr>
                            <td colspan="5"><img height="2" src="/images/boletos/2.png" width="666" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="298" height="13">Beneficiário</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="126" height="13">Agência/Código do Beneficiário</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="34" height="13">Espécie</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="53" height="13">Quantidade</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="120" height="13">Nosso número</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="298" height="12"><span class="campo"><?php echo $dadosboleto["cedente"]; ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="126" height="12"><span class="campo"><?php echo $dadosboleto["agencia_codigo"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="34" height="12"><span class="campo"><?php echo $dadosboleto["especie"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="53" height="12"><span class="campo"><?php echo $dadosboleto["quantidade"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="120" height="12"><span class="campo"><?php echo $dadosboleto["nosso_numero"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="298" height="1"><img height="1" src="/images/boletos/2.png" width="298" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="126" height="1"><img height="1" src="/images/boletos/2.png" width="126" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="34" height="1"><img height="1" src="/images/boletos/2.png" width="34" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="53" height="1"><img height="1" src="/images/boletos/2.png" width="53" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="120" height="1"><img height="1" src="/images/boletos/2.png" width="120" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" colspan="3" height="13">Número do documento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="132" height="13">CPF/CNPJ</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="134" height="13">Vencimento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">Valordocumento</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" colspan="3" height="12"><span class="campo"><?php echo $dadosboleto["numero_documento"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="132" height="12"><span class="campo"><?php echo $dadosboleto["cpf_cnpj"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="134" height="12"><span class="campo"><?php echo $dadosboleto["data_vencimento"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="180" height="12"><span class="campo"><?php echo $dadosboleto["valor_boleto"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="113" height="1"><img height="1" src="/images/boletos/2.png" width="113" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="72" height="1"><img height="1" src="/images/boletos/2.png" width="72" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="132" height="1"><img height="1" src="/images/boletos/2.png" width="132" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="134" height="1"><img height="1" src="/images/boletos/2.png" width="134" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="113" height="13">(-) Desconto / Abatimentos</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="112" height="13">(-) Outras deduções</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="113" height="13">(+) Mora / Multa</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="113" height="13">(+) Outros acréscimos</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">(=) Valor cobrado</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="113" height="12"></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="112" height="12"></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="113" height="12"></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="113" height="12"></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="180" height="12"></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="113" height="1"><img height="1" src="/images/boletos/2.png" width="113" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="112" height="1"><img height="1" src="/images/boletos/2.png" width="112" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="113" height="1"><img height="1" src="/images/boletos/2.png" width="113" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="113" height="1"><img height="1" src="/images/boletos/2.png" width="113" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=659 height="13">Pagador</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=659 height="12"><span class="campo"><?php echo $dadosboleto["sacado"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=659 height="1"><img height="1" src="/images/boletos/2.png" width=659 border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" width="7" height="12"></td>
                            <td class="ct" width=564 >Demonstrativo</td>
                            <td class="ct" width="7" height="12"></td>
                            <td class="ct" width=88 >Autenticação mecânica</td>
                        </tr>
                        <tr>
                            <td width="7" ></td><td class="cp" width=564 >
                                <span class="campo">
                                    <?php echo $dadosboleto["demonstrativo1"] ?><br>
                                    <?php echo $dadosboleto["demonstrativo2"] ?><br>
                                    <?php echo $dadosboleto["demonstrativo3"] ?><br>
                                </span>
                            </td>
                            <td width="7" ></td>
                            <td width=88 ></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tbody>
                        <tr>
                            <td width="7"></td>
                            <td width=500 class="cp"><br /><br /><br /></td>
                            <td width="159"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tr>
                        <td class="ct" width="666"></td>
                    </tr>
                    <tbody>
                        <tr>
                            <td class="ct" width="666"><div align=right>Corte na linha pontilhada</div></td>
                        </tr>
                        <tr>
                            <td class="ct" width="666"><img height="1" src="/images/boletos/6.png" width=665 border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tr>
                        <td class="cp" width="150"><span class="campo"><img src="/images/boletos/logoitau.jpg" width="150" height="40" border="0"></span></td>
                        <td width="3" valign="bottom"><img height="22" src="/images/boletos/3.png" width=2 border="0"></td>
                        <td class="cpt" width=58 valign="bottom"><div align=center><font class=bc><?php echo $dadosboleto["codigo_banco_com_dv"] ?></font></div></td>
                        <td width="3" valign="bottom"><img height="22" src="/images/boletos/3.png" width=2 border="0"></td>
                        <td class=ld align=right width="453" valign="bottom"><span class=ld><span class="campotitulo"><?php echo $dadosboleto["linha_digitavel"] ?></span></span></td>
                    </tr>
                    <tbody>
                        <tr>
                            <td colspan=5><img height="2" src="/images/boletos/2.png" width="666" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=472 height="13">Local de pagamento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">Vencimento</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=472 height="12">Pagável em qualquer Banco até o vencimento</td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="180" height="12"><span class="campo"><?php echo $dadosboleto["data_vencimento"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=472 height="1"><img height="1" src="/images/boletos/2.png" width=472 border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=472 height="13">Beneficiário</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">Agência/Código do Beneficiário</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=472 height="12"><span class="campo"><?php echo $dadosboleto["cedente"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="180" height="12"><span class="campo"><?php echo $dadosboleto["agencia_codigo"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=472 height="1"><img height="1" src="/images/boletos/2.png" width=472 border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="113" height="13">Data do documento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="153" height="13">Nº documento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=62 height="13">Espécie doc.</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="34" height="13">Aceite</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=82 height="13">Data processamento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">Nosso número</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="113" height="12"><div align="left"><span class="campo"><?php echo $dadosboleto["data_documento"] ?></span></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="153" height="12"><span class="campo"><?php echo $dadosboleto["numero_documento"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=62 height="12"><div align="left"><span class="campo"><?php echo $dadosboleto["especie_doc"] ?></span></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="34" height="12"><div align="left"><span class="campo"><?php echo $dadosboleto["aceite"] ?></span></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=82 height="12"><div align="left"><span class="campo"><?php echo $dadosboleto["data_processamento"] ?></span></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="180" height="12"><span class="campo"><?php echo $dadosboleto["nosso_numero"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="113" height="1"><img height="1" src="/images/boletos/2.png" width="113" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="153" height="1"><img height="1" src="/images/boletos/2.png" width="153" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=62 height="1"><img height="1" src="/images/boletos/2.png" width=62 border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="34" height="1"><img height="1" src="/images/boletos/2.png" width="34" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=82 height="1"><img height="1" src="/images/boletos/2.png" width=82 border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" COLSPAN="3" height="13">Uso do banco</td>
                            <td class="ct" valign="top" height="13" width="7"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=83 height="13">Carteira</td>
                            <td class="ct" valign="top" height="13" width="7"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="53" height="13">Espécie</td>
                            <td class="ct" valign="top" height="13" width="7"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="123" height="13">Quantidade</td>
                            <td class="ct" valign="top" height="13" width="7"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="72" height="13">Valor Documento</td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">(=) Valor documento</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" height="12" COLSPAN="3"><div align="left"></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=83><div align="left"><span class="campo"><?php echo $dadosboleto["carteira"] ?></span></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="53"><div align="left"><span class="campo"><?php echo $dadosboleto["especie"] ?></span></div></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="123"><span class="campo"><?php echo $dadosboleto["quantidade"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width="72"><span class="campo"><?php echo $dadosboleto["valor_unitario"] ?></span></td>
                            <td class="cp" valign="top" width="7" height="12"> <img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" align=right width="180" height="12"><span class="campo"><?php echo $dadosboleto["valor_boleto"] ?></span></td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"> <img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="75" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="31" height="1"><img height="1" src="/images/boletos/2.png" width="31" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=83 height="1"><img height="1" src="/images/boletos/2.png" width=83 border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="53" height="1"><img height="1" src="/images/boletos/2.png" width="53" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="123" height="1"><img height="1" src="/images/boletos/2.png" width="123" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="72" height="1"><img height="1" src="/images/boletos/2.png" width="72" border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tbody>
                        <tr>
                            <td align=right width="10">
                                <table cellspacing="0" cellpadding="0" border="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="1" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td valign="top" width=468 rowspan=5><font class="ct">Instruções (Texto de responsabilidade do beneficiário)</font><br /><br />
                                <span class="cp">
                                    <font class="campo">
                                    <?php echo $dadosboleto["instrucoes1"]; ?><br />
                                    <?php echo $dadosboleto["instrucoes2"]; ?><br />
                                    <?php echo $dadosboleto["instrucoes3"]; ?><br />
                                    <?php echo $dadosboleto["instrucoes4"]; ?><br />
                                    <?php echo $dadosboleto["instrucoes5"]; ?>
                                    </font><br /><br />
                                </span></td>
                            <td align=right width="188">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="ct" valign="top" width="180" height="13">(-) Desconto / Abatimentos</td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="cp" valign="top" align=right width="180" height="12"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align=right width="10">
                                <table cellspacing="0" cellpadding="0" border="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="1" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td align=right width="188">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="ct" valign="top" width="180" height="13">(-) Outras deduções</td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="cp" valign="top" align=right width="180" height="12"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align=right width="10">
                                <table cellspacing="0" cellpadding="0" border="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="1" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td align=right width="188">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="ct" valign="top" width="180" height="13">(+) Mora / Multa</td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="cp" valign="top" align=right width="180" height="12"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align=right width="10">
                                <table cellspacing="0" cellpadding="0" border="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="1" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td align=right width="188">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="ct" valign="top" width="180" height="13">(+) Outros acréscimos</td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="cp" valign="top" align=right width="180" height="12"></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align=right width="10">
                                <table cellspacing="0" cellpadding="0" border="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td align=right width="188">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="ct" valign="top" width="180" height="13">(=) Valor cobrado</td>
                                        </tr>
                                        <tr>
                                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                                            <td class="cp" valign="top" align=right width="180" height="12"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tbody>
                        <tr>
                            <td valign="top" width="666" height="1"><img height="1" src="/images/boletos/2.png" width="666" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width=659 height="13">Pagador</td>
                        </tr>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=659 height="12"><span class="campo"><?php echo $dadosboleto["sacado"] ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="cp" valign="top" width="7" height="12"><img height="12" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=659 height="12"><span class="campo"><?php echo $dadosboleto["endereco1"] ?></span></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="cp" valign="top" width=472 height="13"><span class="campo"><?php echo $dadosboleto["endereco2"] ?></span></td>
                            <td class="ct" valign="top" width="7" height="13"><img height="13" src="/images/boletos/1.png" width="1" border="0"></td>
                            <td class="ct" valign="top" width="180" height="13">Cód. baixa</td>
                        </tr>
                        <tr>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width=472 height="1"><img height="1" src="/images/boletos/2.png" width=472 border="0"></td>
                            <td valign="top" width="7" height="1"><img height="1" src="/images/boletos/2.png" width="7" border="0"></td>
                            <td valign="top" width="180" height="1"><img height="1" src="/images/boletos/2.png" width="180" border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" border="0" width="666">
                    <tbody>
                        <tr>
                            <td class="ct" width="7" height="12"></td>
                            <td class="ct" width=409 >Pagador/Avalista</td>
                            <td class="ct" width=250 ><div align=right>Autenticação mecânica - <b class="cp">Ficha de Compensação</b></div></td>
                        </tr>
                        <tr>
                            <td class="ct" colspan="3" ></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tbody>
                        <tr>
                            <td valign="bottom" align="left" height=50><?php fbarcode($dadosboleto["codigo_barras"]); ?></td>
                        </tr>
                    </tbody>
                </table>
                <table cellspacing="0" cellpadding="0" width="666" border="0">
                    <tr>
                        <td class="ct" width="666"></td>
                    </tr>
                    <tbody>
                        <tr>
                            <td class="ct" width="666"><div align=right>Corte na linha pontilhada</div></td>
                        </tr>
                        <tr>
                            <td class="ct" width="666"><img height="1" src="/images/boletos/6.png" width=665 border="0"></td>
                        </tr>
                    </tbody>
                </table>
                <?php
            endforeach;
        endif;
        ?>
    </body>
</html>
