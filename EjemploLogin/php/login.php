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

}