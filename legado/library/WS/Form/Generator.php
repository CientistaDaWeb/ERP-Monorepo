<?php

class WS_Form_Generator {

    /**
     *
     * @param integer $id
     * @param array $fields
     */
    public static function generateForm($id, $fields) {

        $WF = new WS_Form();
        $WF->setMethod('POST');
        $WF->setAttribs(array(
            'id' => $id . 'Form',
            'class' => $id . 'Form formulario'
        ));
        if (!empty($fields)):
            foreach ($fields AS $key => $field):
                $class = 'WS_Form_Element_' . $field['type'];
                $element = new $class($key);
                if (!empty($field['label'])):
                    $element->setLabel($field['label']);
                endif;

                if ($field['type'] == 'Select'):
                    if (!empty($field['option'])):
                        foreach ($field['option'] AS $key => $option):
                            $element->addMultiOption($key, $option);
                        endforeach;
                    endif;
                endif;
                if ($field['type'] == 'Select' || $field['type'] == 'MultiCheckbox'):
                    if (!empty($field['options'])):
                        $element->addMultiOptions($field['options']);
                    endif;
                endif;

                if (isset($field['required'])):
                    $element->setRequired($field['required']);
                endif;

                if (isset($field['description'])):
                    $element->setDescription($field['description']);
                endif;

                if ($field['type'] == 'File'):
                    if (isset($field['extension'])):
                        $element->addValidator('Extension', false, $field['extension']);
                    endif;

                    if (isset($field['multiple'])):
                        $element->setIsArray(true);
                    endif;

                    if (isset($field['size'])):
                        $element->addValidator('Size', false, $field['size'])
                                ->setMaxFileSize($field['size']['max']);
                    endif;
                endif;

                if (isset($field['value'])):
                    $element->setValue($field['value']);
                endif;

                if (isset($field['order'])):
                    $element->setOrder($field['order']);
                endif;

                if (isset($field['ignore'])):
                    $element->setIgnore($field['ignore']);
                endif;

                if (isset($field['class'])):
                    $class = $element->getAttrib('class');
                    $classes = array_merge($class, $field['class']);
                    $element->setAttribs(array(
                        'class' => $classes
                    ));
                endif;

                $WF->addElement($element);
            endforeach;
        endif;

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');
        $WF->addElement($salvar);

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');
        $WF->addElement($cancelar);

        return $WF;
    }

}
