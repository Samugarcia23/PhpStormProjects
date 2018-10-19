<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 19/10/18
 * Time: 9:37
 */
class Operaciones
{
    function cuentaPalabras($palabra){
        $total=strlen($palabra);
        return $total;
    }

    function posicion($palabra , $frase){
        $pos = strpos($frase, 'a', 1);
        $mensaje = "La palabra se encuentra en la posicion " . $pos;
        return $mensaje;
    }
}