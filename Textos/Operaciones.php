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
        $lastPos = 0;
        $positions = array();
        if (strpos($frase, $palabra) == true) {
            while (($lastPos = strpos($frase, $palabra, $lastPos))!== false) {
                $positions[] = $lastPos;
                $lastPos = $lastPos + strlen($palabra);
            }
            foreach ($positions as $pos) {
                echo "<br><br>La letra se encuentra en la posicion " . $pos . "." . PHP_EOL;
            }

        }elseif (strpos($frase, $palabra) == false) echo "<br><br>La frase no contiene la letra." . PHP_EOL;
    }

    function sustitucion($sustituir, $sustituta , $frase){

        if (strpos($frase, $sustituir) == true) {
            $resultado=str_replace($sustituir , $sustituta , $frase , $contador);
            echo "<br><br>La cadena resultante es: " . $resultado . " --> con " . $contador . " reemplazos";
        }elseif (strpos($frase, $sustituir) == false) echo "<br><br>La frase no contiene la letra" . PHP_EOL;
    }
}