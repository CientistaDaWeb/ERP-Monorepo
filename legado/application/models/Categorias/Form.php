<?php

class Categorias_Form extends Zend_Form {

    public function setOrdem() {
        $ordem = new WS_Form_Element_Text('ordem');
        $ordem->setRequired(false)
                ->setLabel('Ordem')
                ->setOrder(2);
        $this->addElement($ordem);
    }

    public function init() {

        $this->setMethod('POST')
                ->setAttrib('id', 'Form_Categorias');

        $id = new WS_Form_Element_Hidden('id');

        $categoria = new WS_Form_Element_Text('categoria');
        $categoria->setRequired(true)
                ->setLabel('Categoria');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $categoria,
            $salvar,
            $cancelar
        ));
    }

}

