<?php

class Contratos_Form extends Zend_Form {

    public function init() {
        $ContratosModel = new Contratos_Model();


        $this->setMethod('POST')
                ->setAttrib('id', 'ContratosForm');

        $id = new WS_Form_Element_Hidden('id');

        $orcamento_id = new WS_Form_Element_Hidden('orcamento_id');

        $data_assinatura = new WS_Form_Element_Date('data_assinatura');
        $data_assinatura->setRequired(true)
                ->setLabel('Data de Assinatura');

        $data_encerramento = new WS_Form_Element_Date('data_encerramento');
        $data_encerramento->setRequired(true)
                ->setLabel('Data de Vencimento');

        $servico_contratado = new WS_Form_Element_Select('servico_contratado');
        $servico_contratado->setRequired(false)
                ->setLabel('Serviço Contratado');
        $servico_contratado->addMultiOptions($ContratosModel->listOptions('servico_contratado'));

        $tipo_efluente = new WS_Form_Element_Select('tipo_efluente');
        $tipo_efluente->setRequired(false)
                ->setLabel('Tipo de Efluente');
        $tipo_efluente->addMultiOptions($ContratosModel->listOptions('tipo_efluente'));

        $condicoes = new WS_Form_Element_Text('condicoes');
        $condicoes->setRequired(true)
                ->setLabel('Condições');

        $valor_transporte = new WS_Form_Element_Money('valor_transporte');
        $valor_transporte->setRequired(false)
                ->setLabel('Valor do Transporte');

        $valor_tratamento = new WS_Form_Element_Money('valor_tratamento');
        $valor_tratamento->setRequired(false)
                ->setLabel('Valor do Tratamento (m³)');

        $acabado = new WS_Form_Element_Select('acabado');
        $acabado->setRequired(true)
                ->setLabel('Contrato Encerrado?');
        $acabado->addMultiOptions($ContratosModel->listOptions('acabado'));

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $orcamento_id,
            $data_assinatura,
            $data_encerramento,
            $servico_contratado,
            $tipo_efluente,
            $condicoes,
            $valor_transporte,
            $valor_tratamento,
            $acabado,
            $salvar,
            $cancelar
        ));
    }

}
