<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 1/02/19
 * Time: 10:25
 */

require_once "ConsUsuarioModel.php";

class SignUpHandlerModel
{

    public static function postNuevoUsuario($usuario){

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();
        $password = "";

        $query = "INSERT INTO Usuarios(usuario, password) VALUES (?,?)";
        $prep_query = $db_connection->prepare($query);
        $prep_query->bind_param("ss", $usuario->user, $usuario->password);
        $password = $usuario->password;
        $usuario->password = password_hash($password, PASSWORD_BCRYPT);
        $prep_query->execute();

        $filasAfectadas = $prep_query->affected_rows;

        $db_connection->close();

        return $filasAfectadas;
    }

}