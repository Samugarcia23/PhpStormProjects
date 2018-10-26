<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 26/10/18
 * Time: 9:13
 */
class Jugadores
{
    private $nombre;
    private $apellido;
    private $edad;
    private $foto;

    function set_Name($nom){
        $this->nombre=$nom;
    }

    function get_Name(){
        return $this->nombre;
    }

    function set_Apellido($ape){
        $this->apellido=$ape;
    }

    function get_Apellido(){
        return $this->apellido;
    }

    function set_Edad($edad){
        $this->edad=$edad;
    }

    function get_Edad(){
        return $this->edad;
    }

    function set_Foto($foto){
        $this->foto=$foto;
    }

    function get_Foto(){
        return $this->foto;
    }
}