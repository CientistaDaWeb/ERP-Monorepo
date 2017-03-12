<?php

class Textos_Form extends Zend_Form {

    public function init() {

        $TextosCategoriasModel = new TextosCategorias_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'TextosForm');


        $categoria_id = new WS_Form_Element_Select('categoria_id');
        $categoria_id->setRequired(true)
                ->setLabel('Categoria');
        $categoria_id->addMultiOption('', 'Selecione');
        $categoria_id->addMultiOptions($TextosCategoriasModel->fetchPair());

        $titulo = new WS_Form_Element_Text('titulo');
        $titulo->setRequired(true)
                ->setLabel('Título');

        $descricao = new WS_Form_Element_Textarea('descricao');
        $descricao->setRequired(true)
                ->setLabel('Descrição');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $categoria_id,
            $titulo,
            $descricao,
            $salvar,
            $cancelar
        ));
    }

}

