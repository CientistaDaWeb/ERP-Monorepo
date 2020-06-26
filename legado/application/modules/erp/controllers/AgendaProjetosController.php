<?php

class Erp_AgendaProjetosController extends Erp_Controller_Action {

    public function init() {
        $this->model = new Projetos_Model();
        parent::init();
    }

    public function indexAction() {

    }

    public function eventosAction() {
        $data = $this->_getAllParams();
        $dataInicio = new Zend_Date($data['start']);
        $inicio = $dataInicio->toString('yyyy-MM-dd');
        $dataFim = new Zend_Date($data['end']);
        $fim = $dataFim->toString('yyyy-MM-dd');

        $usuario_id = '';
        $auth = new WS_Auth('erp');
        $user = $auth->getIdentity();
        if ($user->papel != 'A'):
            if ($user->id != 14):
                $usuario_id = $user->id;
            endif;
        endif;
        $items = $this->model->agenda($inicio, $fim, $usuario_id);

        if (!empty($items)):
            foreach ($items AS $item):
                $item = $this->model->adjustToAgenda($item);
                $evento['id'] = $item['id'];
                $evento['title'] = ' ' . $item['nome'] . ' (' . $item['projetista'] . ')';
                $evento['start'] = $item['data_entrega'];
                $evento['end'] = $item['data_entrega'];
                $evento['allDay'] = true;
                $evento['color'] = $item['cor'];
                $eventos[] = $evento;
            endforeach;
            $ZJ = new Zend_Json();
            print_r($ZJ->encode($eventos));
        endif;
        exit();
    }

}