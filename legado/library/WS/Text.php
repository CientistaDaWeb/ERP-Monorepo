<?php

class WS_Text {

    public static function slug($data, $delimiter = '-') {
        $data = self::withoutAccents($data);

        $data = preg_replace("/[\/_| -]+/", $delimiter, $data);

        $patterns = array('/"/', "/'/");
        $replace = array('', '');
        return preg_replace($patterns, $replace, $data);
    }

    public static function withoutAccents($data) {
        $trimmed = ltrim(rtrim($data));
        $convert = mb_convert_case($trimmed, MB_CASE_LOWER, "UTF-8");
        $patterns = array(
            '/Á/', '/É/', '/Í/', '/Ó/', '/Ú/',
            '/À/', '/È/', '/Ì/', '/Ò/', '/Ù/',
            '/á/', '/é/', '/í/', '/ó/', '/ú/', '/ý/',
            '/à/', '/è/', '/ì/', '/ò/', '/ù/',
            '/â/', '/ê/', '/î/', '/ô/', '/û/',
            '/Â/', '/Ê/', '/Î/', '/Ô/', '/Û/',
            '/ä/', '/ë/', '/ï/', '/ö/', '/ü/', '/ÿ/',
            '/Ä/', '/Ë/', '/Ï/', '/Ö/', '/Ü/', '/Ÿ/',
            '/ã/', '/õ/', '/ñ/', '/å/', '/ø/', '/š/',
            '/Ã/', '/Õ/', '/Ñ/', '/Å/', '/Ø/', '/Š/',
            '/ç/', '/&#287;/', '/&#305;/', '/ö/', '/&#351;/', '/ü/');

        $replace = array(
            'a', 'e', 'i', 'o', 'u',
            'a', 'e', 'i', 'o', 'u',
            'a', 'e', 'i', 'o', 'u', 'y',
            'a', 'e', 'i', 'o', 'u',
            'a', 'e', 'i', 'o', 'u',
            'a', 'e', 'i', 'o', 'u',
            'a', 'e', 'i', 'o', 'u', 'y',
            'a', 'e', 'i', 'o', 'u', 'y',
            'a', 'o', 'n', 'a', 'q', 's',
            'a', 'o', 'n', 'a', 'q', 's',
            'c', 'g', 'i', 'o', 's', 'u');

        return preg_replace($patterns, $replace, $convert);
    }

    public static function onlyNumber($data) {
        $data = preg_replace("/[^0-9]/", "", $data);
        return $data;
    }

    public static function clearSpaces($data) {
        $data = rtrim(ltrim($data));
        return $data;
    }

}
