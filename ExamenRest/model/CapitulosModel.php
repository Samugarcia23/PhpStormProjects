<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 30/11/18
 * Time: 9:41
 */
class CapitulosModel implements JsonSerializable
{

    private $titulo;
    private $capInicio;
    private $capFin;
    private $codLibro;
    private $codCapitulo;

    public function __construct($titulo,$capInicio, $capFin)
    {
        $this->titulo=$titulo;
        $this->capInicio=$capInicio;
        $this->capFin=$capFin;
    }

    function jsonSerialize()
    {
        return array(
            'codCapitulo' => $this->codCapitulo,
            'codLibro' => $this->codLibro,
            'titulo' => $this->titulo,
            'capInicio' => $this->capInicio,
            'capFin' => $this->capFin
        );
    }

    public function __sleep(){
        return array('codCapitulo', 'codLibro' , 'titulo' , 'capInicio', 'capFin' );
    }

    public function getCodLibro(){
        return $this->codLibro;
    }

    public function setCodLibro($codLibro){
        $this->codLibro = $codLibro;
    }

    public function getCodCap(){
        return $this->codCapitulo;
    }

    public function setCodCap($codCap){
        $this->codCapitulo = $codCap;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function getCapInicio(){
        return $this->capInicio;
    }

    public function setCapInicio($capInicio){
        $this->capInicio = $capInicio;
    }

    public function getCapFin(){
        return $this->capFin;
    }

    public function setCapFin($capFin){
        $this->capFin = $capFin;
    }

}