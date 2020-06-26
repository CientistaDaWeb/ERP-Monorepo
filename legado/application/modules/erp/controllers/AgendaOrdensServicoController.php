<?php

class Erp_AgendaOrdensServicoController extends Erp_Controller_Action {

    public function init() {
        $this->model = new OrdensServico_Model();
        parent::init();
        $this->model->_title = 'Agenda de Ordens de Serviço';
    }

    public function indexAction() {

    }

    public function eventosAction() {
        $data = $this->_getAllParams();
        $dataInicio = new Zend_Date($data['start']);
        $inicio = $dataInicio->toString('yyyy-MM-dd');
        $dataFim = new Zend_Date($data['end']);
        $fim = $dataFim->toString('yyyy-MM-dd');

        $items = $this->model->eventos($inicio, $fim);
        if (!empty($items)):
            foreach ($items AS $item):
                $evento['id'] = $item['id'];
                $evento['title'] = 'OS ' . $item['orcamento_id'] . '.' . $item['sequencial'] . ' - ' . $item['razao_social'];
                $evento['start'] = $item['data_coleta'] . ' ' . $item['hora_coleta'];
                $evento['end'] = $item['data_coleta'] . ' ' . $item['hora_coleta'];
                $evento['allDay'] = false;
                $eventos[] = $evento;
            endforeach;
            $temeventos = true;
        endif;

        $FolgasModel = new Folgas_Model();
        $items = $FolgasModel->agenda($inicio, $fim);

        if (!empty($items)):
            foreach ($items AS $item):
                $evento['id'] = false;
                $evento['title'] = $item['titulo'];
                $evento['start'] = $item['data'] . ' ' . $item['hora_inicio'];
                $evento['end'] = $item['data'] . ' ' . $item['hora_fim'];
                $evento['allDay'] = false;
                $evento['color'] = '#990000';
                $eventos[] = $evento;
            endforeach;
            $temeventos = true;
        endif;


        if ($temeventos):
            $ZJ = new Zend_Json();
            print_r($ZJ->encode($eventos));
        endif;
        exit();
    }

}
