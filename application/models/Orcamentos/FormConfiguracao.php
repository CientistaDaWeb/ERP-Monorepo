<?php

class Orcamentos_FormConfiguracao extends Zend_Form {

    public function init() {

        $TextosModel = new Textos_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'OrcamentosConfiguracaoForm');

        $id = new WS_Form_Element_Hidden('id');

        $titulo_id = new WS_Form_Element_Select('titulo_id');
        $titulo_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $titulo_id->addMultiOption('', 'Usar Modelo');
        $titulo_id->addMultiOptions($TextosModel->getByCategoria(8));

        $titulo = new WS_Form_Element_Textarea('titulo');
        $titulo->setRequired(true)
                ->removeDecorator('label');

        $condicao_pagamento_id = new WS_Form_Element_Select('condicao_pagamento_id');
        $condicao_pagamento_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $condicao_pagamento_id->addMultiOption('', 'Usar Modelo');
        $condicao_pagamento_id->addMultiOptions($TextosModel->getByCategoria(1));

        $condicoes_pagamento = new WS_Form_Element_Textarea('condicoes_pagamento');
        $condicoes_pagamento->setRequired(true)
                ->removeDecorator('label');

        $prazo_entrega_id = new WS_Form_Element_Select('prazo_entrega_id');
        $prazo_entrega_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');
        $prazo_entrega_id->addMultiOption('', 'Usar Modelo');
        $prazo_entrega_id->addMultiOptions($TextosModel->getByCategoria(2));

        $prazo_entrega = new WS_Form_Element_Textarea('prazo_entrega');
        $prazo_entrega->setRequired(true)
                ->removeDecorator('label');

        $observacao_id = new WS_Form_Element_Select('observacao_id');
        $observacao_id->setRequired(false)
                ->setIgnore(true)
                ->removeDecorator('label');

        $observacao_id->addMultiOption('', 'Usar Modelo');
        $observacao_id->addMultiOptions($TextosModel->getByCategoria(3));

        $observacoes = new WS_Form_Element_Textarea('observacoes');
        $observacoes->setRequired(true)
                ->removeDecorator('label');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $titulo_id,
            $titulo,
            $condicao_pagamento_id,
            $condicoes_pagamento,
            $prazo_entrega_id,
            $prazo_entrega,
            $observacao_id,
            $observacoes,
            $salvar,
            $cancelar
        ));

        $this->addDisplayGroup(
                array('titulo_id', 'titulo'),
                'tituloOrcamento',
                array(
                    'legend' => 'Título'
                )
        );

        $this->addDisplayGroup(
                array('condicao_pagamento_id', 'condicoes_pagamento'),
                'condicoesPagamento',
                array(
                    'legend' => 'Condições de Pagamento'
                )
        );

        $this->addDisplayGroup(
                array('prazo_entrega_id', 'prazo_entrega'),
                'prazoEntrega',
                array(
                    'legend' => 'Validade da Proposta'
                )
        );

        $this->addDisplayGroup(
                array('observacao_id', 'observacoes'),
                'Observacoes',
                array(
                    'legend' => 'Observações'
                )
        );

        $this->addDisplayGroup(
                array('salvar', 'cancelar'),
                'botoes'
        );
        $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset'
        ));
    }

}

