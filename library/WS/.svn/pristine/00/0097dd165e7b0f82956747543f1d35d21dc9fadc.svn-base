<?php

class WS_Money {

    protected $_extenso = array(
        '0' => 'zero',
        '1' => 'um',
        '2' => 'dois',
        '3' => 'três',
        '4' => 'quatro',
        '5' => 'cinco',
        '6' => 'seis',
        '7' => 'sete',
        '8' => 'oito',
        '9' => 'nove',
        '10' => 'dez',
        '11' => 'onze',
        '12' => 'doze',
        '13' => 'treze',
        '14' => 'quatorze',
        '15' => 'quinze',
        '16' => 'dezesseis',
        '17' => 'dezessete',
        '18' => 'dezoito',
        '19' => 'dezenove',
        '20' => 'vinte',
        '30' => 'trinta',
        '40' => 'quarenta',
        '50' => 'cinquenta',
        '60' => 'sessenta',
        '70' => 'setenta',
        '80' => 'oitenta',
        '90' => 'noventa',
        '100' => 'cento',
        '200' => 'duzentos',
        '300' => 'trezentos',
        '400' => 'quatrocentos',
        '500' => 'quinhentos',
        '600' => 'seiscentos',
        '700' => 'setecentos',
        '800' => 'oitocentos',
        '900' => 'novecentos',
    );
    protected $_milhar = array(
        1 => array('singular' => 'mil', 'plural' => 'mil'),
        2 => array('singular' => 'milhão', 'plural' => 'milhões'),
        3 => array('singular' => 'bilhão', 'plural' => 'bilhões'),
        4 => array('singular' => 'trilhão', 'plural' => 'trilhões'),
        5 => array('singular' => 'quatrilhão', 'plural' => 'quatrilhões'),
        6 => array('singular' => 'quinquilhão', 'plural' => 'quinquilhões'),
    );

    public static function adjustToView($data, $casasDecimais = 2, $mostraMoeda = true) {
        if (!empty($data)):
            $valor = number_format($data, $casasDecimais, ',', '.');
            if ($mostraMoeda):
                $valor = 'R$ ' . $valor;
            endif;
            return $valor;
        else:
            return 0;
        endif;
    }

    public static function adjustToFloat($data) {
        $data = str_replace('.', '', $data);
        $data = str_replace(',', '.', $data);
        return $data;
    }

    public static function adjustToDb($data, $casasDecimais = 2) {
        $data = (float) $data;
        if (is_float($data)):
            return ($data) ? number_format($data, $casasDecimais, '.', '') : 0;
        else:
            return false;
        endif;
    }

    public function infFull($data) {
        $retorno = '';
        $valor = $this->adjustToDb($data);
        $centavos = substr($valor, -2);

        for ($i = 15; $i >= 3; $i = $i - 3) {
            $var = floor($valor / pow(10, $i));
            if ($var > 0):
                if ($var == 1):
                    $retorno .= $this->centenar($var) . ' ' . $this->_milhar[$i / 3]['singular'] . ' ';
                else:
                    $retorno .= $this->centenar($var) . ' ' . $this->_milhar[$i / 3]['plural'] . ' ';
                endif;
                $valor -= ( $var * pow(10, $i));
            endif;
        }

        $milhar = floor($valor / 1000);
        if ($milhar > 0):
            $retorno .= $this->centenar($milhar) . ' mil ';
            $valor -= ( $milhar * 1000);
        endif;
        if (floor($valor) > 0):
            if (floor($valor) == 1):
                $retorno .= $this->centenar($valor) . ' real ';
            else:
                $retorno .= $this->centenar($valor) . ' reais ';
            endif;
        endif;
        if ($centavos > 0):
            if ($centavos == 1):
                $retorno .= $this->dezenar($centavos) . ' centavo';
            else:
                $retorno .= $this->dezenar($centavos) . ' centavos';
            endif;
        endif;
        $retorno = trim($retorno);
        if (substr($retorno, 0, 2) == 'e '):
            $retorno = substr($retorno, 2);
        endif;
        return $retorno;
    }

    public function centenar($data) {
        $valor = $data;
        $seila = floor($data);
        $retorno = '';
        if (!empty($this->_extenso[$seila])):
            if ($seila != 100):
                $retorno .= ' e ';
                $retorno .= $this->_extenso[$seila];
            else:
                $retorno .= 'cem';
            endif;
        else:
            $centena = floor($data / 100);
            if ($centena > 0):
                $valor -= ( $centena * 100);
                $retorno .= $this->_extenso[substr($centena * 100, -3)];
            endif;
            $retorno .= $this->dezenar($valor);
        endif;
        return $retorno;
    }

    public function dezenar($data) {
        $valor = $data;
        $retorno = '';
        if (!empty($this->_extenso[$data])):
            $retorno .= ' e ';
            $retorno .= $this->_extenso[$data];
        else:
            $dezena = floor($data / 10);
            if ($dezena > 0):
                $retorno .= ' e ';
                $valor -= ( $dezena * 10);
                $retorno .= $this->_extenso[$dezena * 10];
            endif;
            if ($valor > 0):
                $valor = floor($valor);
                $retorno .= ' e ' . $this->_extenso[$valor];
            endif;
        endif;
        return $retorno;
    }

}
