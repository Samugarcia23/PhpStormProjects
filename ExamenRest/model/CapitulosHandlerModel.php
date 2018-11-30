<?php

/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 30/11/18
 * Time: 10:23
 */

require_once "ConsCapModel.php";
require_once "ConsLibrosModel.php";

class CapitulosHandlerModel
{
    //Funcion que devuelve un listado de libros con capitulos

    public static function getCapitulo($id, $capitulo){

        $capitulo = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $valid = self::isValid($id);

        if ($valid === true && $capitulo == "capitulo"){
            $query = "SELECT capitulos.titulo, capInicio, capFin FROM " . \ConstantesDB\ConsCapModel::TIT .
                        "INNER JOIN " . \ConstantesDB\ConsLibrosModel::TITULO . " ON capitulos.idLibro = libros.codigo WHERE libros.codigo = ?";

            $prep_query = $db_connection->prepare($query);
            $prep_query->bind_param('i', $id);
            $prep_query->execute();

            $prep_query->bind_result($titulo,$capInicio, $capFin);
            $capitulo = new CapitulosModel($titulo,$capInicio, $capFin);

        }

        $db_connection->close();

        return $capitulo;
    }

    public static function isValid($id)
    {
        $res = false;

        if (ctype_digit($id)) {
            $res = true;
        }
        return $res;
    }

}