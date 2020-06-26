<?php

class Erp_Date extends WS_Date {
    /* Limita a data */

    public function dateLimit($data, $dias,  $campo) {
        if (!empty($data[$campo])):
            $data_digitada = new WS_Date($data[$campo]);
            $data_maxima = new WS_Date();
            $data_maxima->today();
            $data_maxima->sub($dias, Zend_Date::DAY);
            $limite = $data_digitada->compare($data_maxima);
            if ($limite < 0):
                $data[$campo] = $data_maxima->toString('dd/MM/YYYY');
            endif;
        endif;
        return $data;
    }

}
