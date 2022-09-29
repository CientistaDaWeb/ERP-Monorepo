<?php

class UsuariosCompromissos_Form extends Zend_Form {

    public function init() {

        $UsuariosModel = new Usuarios_Model();
        $ClientesModel = new Clientes_Model();

        $this->setMethod('POST')
                ->setAttrib('id', 'UsuariosCompromissosForm');

        $id = new WS_Form_Element_Hidden('id');

        $usuario_id = new WS_Form_Element_Select('usuario_id');
        $usuario_id->setRequired(true)
                ->setLabel('Usuario');
        $usuario_id->addMultiOptions($UsuariosModel->fetchPair());

        $cliente_id = new WS_Form_Element_Select('cliente_id');
        $cliente_id->setRequired(true)
                ->setLabel('Cliente');
        $cliente_id->addMultiOptions(array('' => 'Nenhum Cliente'));
        $cliente_id->addMultiOptions($ClientesModel->fetchPair());

        $titulo = new WS_Form_Element_Text('titulo');
        $titulo->setRequired(true)
                ->setLabel('Título');

        $local = new WS_Form_Element_Text('local');
        $local->setRequired(false)
                ->setLabel('Local');

        $data = new WS_Form_Element_Date('data');
        $data->setRequired(true)
                ->setLabel('Data');

        $hora = new WS_Form_Element_Hour('hora');
        $hora->setRequired(true)
                ->setLabel('Hora');

        $descricao = new WS_Form_Element_Textarea('descricao');
        $descricao->setRequired(true)
                ->setLabel('Descrição');

        $status = new WS_Form_Element_Select('status');
        $status->setRequired(true)
                ->setLabel('Status');
        $status->addMultiOptions(array('A' => 'Aguardando', 'C' => 'Concluído'));

        $repeticao = new WS_Form_Element_Number('repeticao');
        $repeticao->setRequired(true)
                ->setIgnore(true)
                ->setLabel('Repetir quantas vezes?')
                ->setValue(1);

        $periodicidade = new WS_Form_Element_Select('periodicidade');
        $periodicidade->setRequired(true)
                ->setIgnore(true)
                ->setLabel('Status');
        $periodicidade->addMultiOptions(array('7' => 'Semanal', '14' => 'Quinzenal', '30' => 'Mensal'));

        $salvar = new WS_Form_Element_Submit('salvar');
        $salvar->setValue('Salvar');

        $cancelar = new WS_Form_Element_Cancel('cancelar');
        $cancelar->setValue('Cancelar');

        $this->addElements(array(
            $id,
            $usuario_id,
            $cliente_id,
            $titulo,
            $local,
            $descricao,
            $data,
            $hora,
            $status,
            $repeticao,
            $periodicidade,
            $salvar,
            $cancelar
        ));
    }

}

