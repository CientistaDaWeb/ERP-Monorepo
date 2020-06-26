<?php

class Bens_Model extends WS_Model {

    public function __construct() {
        $this->_db = new Bens_Db();
        $this->_pair = 'nome';
        $this->_title = 'Gerenciador de Investimentos';
        $this->_singular = 'Investimento';
        $this->_plural = 'Investimentos';

        parent::__construct();
    }

    public function adjustToView($data, $comparacao = NULL, $inicial = NULL) {
        $data = $this->recalculaValor($data, $comparacao, $inicial);
//        $data['valor_atual'] = $depreciado['total'];
//        $data['meses'] = $depreciado['meses'];
//        $data['valor_depreciado'] = $data['valor_compra'] - $data['valor_atual'];
//        $data['depreciacao'] = $data['valor_compra'] / $data['meses_quitacao'];

        return parent::adjustToView($data);
    }

    public function setFormFields() {
        $this->_formFields = array(
            'id' => array(
                'type' => 'Hidden'
            ),
            'nome' => array(
                'label' => 'Nome do Bem',
                'type' => 'Text',
                'required' => true
            ),
            'valor_compra' => array(
                'label' => 'Valor de Compra',
                'type' => 'Money',
                'required' => true
            ),
            'data_aquisicao' => array(
                'label' => 'Data de Aquisição',
                'type' => 'Date',
                'required' => true
            ),
            'meses_quitacao' => array(
                'label' => 'Meses para retorno do investimento',
                'type' => 'Number',
                'required' => true
            ),
        );
    }

    public function setAdjustFields() {
        $this->_adjustFields = array(
            'data_aquisicao' => 'date',
        );
    }

    public function recalculaValor($item, $final = NULL, $inicial = NULL) {
//        if (!$final):
//            $inicioMes = mktime(0, 0, 0, date('m'), 1, date('Y'));
//            $final = date('Y-m-d', $inicioMes);
//        endif;

        $hoje = new Zend_Date($final);
        $compra = new Zend_Date($item['data_aquisicao']);
        if ($inicial):
            $dtini = new Zend_Date($inicial);
            $dtini->sub(3, Zend_Date::DAY);
            if ($dtini->compare($compra) < 0):
                $compra = $dtini;
            endif;
        endif;

        $aquisicao = new Zend_Date($compra);
        $aquisicao->add($item['meses_quitacao'], Zend_Date::MONTH);
        $vencido = $hoje->compare($aquisicao);

        if ($vencido > 0):
            $item['depreciacao'] = 0;
            $item['valor_depreciado'] = $item['valor_compra'];
            $item['meses'] = $item['meses_quitacao'];
            $item['valor_atual'] = 0;
        else:
            $diferenca = $hoje->sub($compra)->toString(Zend_Date::TIMESTAMP);
            $fator = floor(((($diferenca / 60) / 60) / 24) / 30); // meses
            $fator --;
            $item['depreciacao'] = $item['valor_compra'] / $item['meses_quitacao'];
            $item['valor_depreciado'] = ($fator * $item['depreciacao']);
            $item['meses'] = $fator;
            $item['valor_atual'] = $item['valor_compra'] - $item['valor_depreciado'];
        endif;
        return $item;
    }

    public function getByPeriod($data_final, $data_inicial = null) {
        $itens = $this->listagem();
        $return = 0;
        foreach ($itens AS $item):
            $investimento = $this->recalculaValor($item, $data_final, $data_inicial);
            $return += $investimento['valor_atual'];
        endforeach;
        return $return;
    }

}
