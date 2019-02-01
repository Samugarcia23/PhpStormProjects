<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 1/02/19
 * Time: 10:14
 */
require_once "ConsUsuarioModel.php";
use Firebase\JWT\JWT;


class LoginHandlerModel
{
    public static function getUserData($usuario){

        $usuario = null;
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "SELECT usuario FROM Usuarios WHERE usuario = ? AND password = ?";

        $prep_query = $db_connection->prepare($query);
        $prep_query->bind_param("ss", $user);

        $prep_query->execute();
        $prep_query->bind_result($usu, $pass);

        $usuario = new UsuarioModel($usu, $pass);

        $array = $prep_query->get_result()->fetch_assoc();
        $hash = $array["password"];

        if (password_verify($pass, $hash)){

            // create a token
            $payloadArray = array();
            $payloadArray['user'] = $usu;
            if (isset($nbf)) {$payloadArray['nbf'] = $nbf;}
            if (isset($exp)) {$payloadArray['exp'] = $exp;}
            $token = JWT::encode($payloadArray, $pass);
            // return to caller
            $returnArray = array('token' => $token);
            $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);

            echo $jsonEncodedReturnArray;

        }else{

        }

        $db_connection->close();

        return $usuario;

    }
}