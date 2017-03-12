<?php

class Servicos_Form extends Zend_Form {

    public function init() {
        $ServicosCategoriasModel = new ServicosCategorias_Model();
        $ServicosModel = new Servicos_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'ServicosForm');

        $id = new WS_Form_Element_Hidden('id');

        $categoria_id = new WS_Form_Element_Select('categoria_id');
        $categoria_id->setRequired(true)
                ->setLabel('Categoria');
        $categoria_id->addMultiOption('', 'Selecione');

        $categoria_id->addMultiOptions($ServicosCategoriasModel->fetchPair());

        $servico = new WS_Form_Element_Text('servico');
        $servico->setRequired(true)
                ->setLabel('Serviço');

        $valor_unitario = new WS_Form_Element_Money('valor_unitario');
        $valor_unitario->setRequired(true)
                ->setLabel('Valor por Unidade');

        $descricao = new WS_Form_Element_Textarea('descricao');
        $descricao->setRequired(true)
                ->setLabel('Descrição');

        $certificado = new WS_Form_Element_Select('certificado');
        $certificado->setRequired(true)
                ->setLabel('Gera Certificado');
        $certificado->addMultiOptions($ServicosModel->listOptions('certificado'));

        $tipo = new WS_Form_Element_Select('tipo');
        $tipo->setRequired(true)
                ->setLabel('Tipo de Resíduo');
        $tipo->addMultiOptions($ServicosModel->listOptions('tipo'));

        $unidade = new WS_Form_Element_Text('unidade');
        $unidade->setRequired(true)
                ->setLabel('Unidade de Medida');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $categoria_id,
            $servico,
            $valor_unitario,
            $descricao,
            $certificado,
            $tipo,
            $unidade,
            $salvar,
            $cancelar
        ));
    }

}

