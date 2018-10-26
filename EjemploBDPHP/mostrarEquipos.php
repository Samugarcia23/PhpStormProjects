<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 26/10/18
 * Time: 10:33
 */
require_once "Database.php";
require_once "equipos.php";
require_once "tablaJugadores.php";
require_once "EquiposBasket.php";

class mostrarEquipos
{
    function selectEquipo(){
        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        $query = "SELECT ". \equipos::NOMEQUIPO . " "
        ." FROM ". \equipos::TABLE_NAME;

        return $result = $mysqli->query($query); //Retorna los nombre de equipos
    }

    function cargarLista(){

        $result=$this->selectEquipo();

        echo "<select name='equipos'>";

        while ($row = $result->fetch_assoc()) {

            unset($name);
            $name = $row[\equipos::NOMEQUIPO ];
            echo '<option value="'.$name.'">'.$name.'</option>';

        }

        echo "</select>";

    }

}