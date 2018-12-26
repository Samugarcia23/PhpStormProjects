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
else {

    $query = "INSERT INTO " . \ConsUsuarioModel::TABLE_NAME . "(usuario, password) VALUES (?,?)";
    $prep_query = $conexion->prepare($query);
    $prep_query->bind_param("ss", $user, $password);

    $user = $_POST["user"];
    $password = $_POST["password"];

    $password = password_hash($password, PASSWORD_BCRYPT);
    if($user != "" && $password != ""){
        if ($prep_query->execute()){
            echo "¡El usuario " . $user . " se ha introducido correctamente!";
            echo "<br><a href=\"/index.html\">Volver a inicio</a>";
        }
        else {
            echo "Error, intentelo de nuevo";
            echo "<br><a href=\"/index.html\">Volver a inicio</a>";
        }
    }
    else
        echo "Error, No puede haber campos vacios";

    $database->closeConnection();
}
