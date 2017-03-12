<?php

class Estados_Form extends Zend_Form {

    public function init() {
        $this->setMethod('POST')
                ->setAttrib('id', 'EstadosForm');

        $id = new WS_Form_Element_Hidden('id');

        $estado = new WS_Form_Element_Text('estado');
        $estado->setRequired(true)
                ->setLabel('Estado');

        $uf = new WS_Form_Element_Text('uf');
        $uf->setRequired(true)
                ->setLabel('UF');

        $nfe_id = new WS_Form_Element_Text('nfe_id');
        $nfe_id->setRequired(true)
                ->setLabel('Id para a CT-e');

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $estado,
            $uf,
            $nfe_id,
            $salvar,
            $cancelar
        ));
    }

}

