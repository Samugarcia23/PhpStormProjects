<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 26/10/18
 * Time: 8:33
 */
class EquiposBasket
{
    private $nombreEquipo;
    private $numJugadores;

    function set_nombreEquipo($nombre){
        $this->nombreEquipo=$nombre;
    }

    function get_nombreEquipo(){
        return $this->nombreEquipo;
    }

    function set_numJugadores($num){
        $this->numJugadores=$num;
    }

    function get_numJugadores(){
        return $this->numJugadores;
    }
}
