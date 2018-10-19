<?php
/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 19/10/18
 * Time: 8:29
 */
class Persona{
    var $nombre;
    var $apellido;
    var $telefono;
    var $id;

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

    function set_Telefono($tel){
        $this->telefono=$tel;
    }

    function get_Telefono(){
        return $this->telefono;
    }

    function set_Id($dni){
        $this->id=$dni;
    }

    function get_Id(){
        return $this->id;
    }
}