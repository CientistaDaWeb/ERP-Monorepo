<?php

class WS_Cript {

    public static function criptografa($texto) {
        $hash = 'ws846uk';
        $cript = $texto;
        //$cript = strtoupper($cript);
        $cript = strrev($cript);
        $cript = base64_encode($cript);
        $cript.= $hash;
        $cript = base64_encode($cript);
        $cript = strrev($cript);
        return $cript;
    }

    public static function descriptografa($texto) {
        $hash = 'ws846uk';
        $decript = $texto;
        $decript = strrev($decript);
        $decript = base64_decode($decript);
        $decript = str_replace($hash, '', $decript);
        $decript = base64_decode($decript);
        $decript = strrev($decript);
        //$decript = strtolower($decript);

        return $decript;
    }

}
