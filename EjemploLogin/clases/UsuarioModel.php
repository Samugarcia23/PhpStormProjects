<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 17/12/18
 * Time: 10:32
 */
class UsuarioModel implements JsonSerializable
{
    private $user, $password;

    public function __construct($user, $pass)
    {
        $this->user=$user;
        $this->password=$pass;
    }

    function jsonSerialize()
    {
        return array(
            'usuario' => $this->user,
            'password' => $this->password
        );
    }

    public function __sleep(){
        return array('usuario', 'password');
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}