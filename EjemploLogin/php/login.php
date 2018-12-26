<?php
/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 17/12/18
 * Time: 9:52
 */
require_once "../bbdd/DatabaseModel.php";
require_once "../clases/ConsUsuarioModel.php";

$database = DatabaseModel::getInstance();
$conexion = $database->getConnection();

if($conexion->connect_error)
{
    trigger_error("Error al conectar a MySQL".$conexion->connect_error, E_USER_ERROR);
}
else{
    $query = "SELECT " . \ConsUsuarioModel::PASSWORD . " FROM  " . \ConsUsuarioModel::TABLE_NAME . " WHERE "
    . \ConsUsuarioModel::USER . " = ?";
    $prep_query = $conexion->prepare($query);
    $prep_query->bind_param("s", $user);

    $user = $_POST["user"];
    $password = $_POST["pass"];

    $prep_query->execute();
    $array = $prep_query->get_result()->fetch_assoc();
    $hash = $array["password"];

    if($user != "" && $password != ""){
        if (password_verify($password, $hash)){
            echo "El usuario " . $user . " es correcto!";
            echo "<br><a href=\"/index.html\">Volver a inicio</a>";
        }else{
            echo "Error, usuario o contraseña incorrectos";
            echo "<br><a href=\"/index.html\">Volver a inicio</a>";
        }
    }
    else
        echo "Error, No puede haber campos vacios";

    $database->closeConnection();

}