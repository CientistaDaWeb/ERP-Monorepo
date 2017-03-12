<?php

class WS_Date extends Zend_Date {

    public static function today() {
        $ZD = new Zend_Date();
        return $ZD;
    }

    public static function adjustToDb($data) {
        $test = explode('/', $data);
        if (count($test) == 3):
            $ZD = new Zend_Date($data, 'dd/MM/yyyy');
            return $ZD->toString('yyyy-MM-dd');
        else:
            return false;
        endif;
    }

    public static function adjustToView($data) {
        if (!empty($data)):
            $test = explode('-', $data);
            if (count($test) == 3):
                $ZD = new Zend_Date($data, 'yyyy-MM-dd');
                return $ZD->toString('dd/MM/yyyy');
            else:
                return false;
            endif;
        endif;
    }

    public static function adjustToViewWithHour($data) {
        if (!empty($data)):
            $ZD = new Zend_Date($data);
            return $ZD->toString('dd/MM/yyyy HH:mm:ss');
        endif;
    }

    public static function adjustToDbWithHour($data) {
        if (!empty($data)):
            $ZD = new Zend_Date($data);
            return $ZD->toString('yyyy-DD-dd HH:mm:ss');
        endif;
    }

    public static function dateDifference($date1, $date2) {
        $d1 = (is_string($date1) ? strtotime($date1) : $date1);
        $d2 = (is_string($date2) ? strtotime($date2) : $date2);

        $diff_secs = abs($d1 - $d2);
        $base_year = min(date("Y", $d1), date("Y", $d2));

        $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);

        return array(
            "years" => abs(substr(date('Ymd', $d1) - date('Ymd', $d2), 0, -4)),
            "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
            "months" => date("n", $diff) - 1,
            "days_total" => floor($diff_secs / (3600 * 24)),
            "days" => date("j", $diff) - 1,
            "hours_total" => floor($diff_secs / 3600),
            'horas' => $diff_secs / 3600,
            "hours" => date("G", $diff),
            "minutes_total" => floor($diff_secs / 60),
            "minutes" => (int) date("i", $diff),
            "seconds_total" => $diff_secs,
            "seconds" => (int) date("s", $diff)
        );
    }

    public static function minutesToHours($minutes) {
        $retorno = number_format($minutes / 60, 2);
        return $retorno;
    }

}
