<?php

require_once "ConsLibrosModel.php";
require_once "ConsCapModel.php";


class LibroHandlerModel
{

    //EXAMEN
    //Funcion que devuelve o todos los capitulos de un libro o 1 capitulo especifico
    public static function getCapitulo($id, $capitulo, $idCap){

        $listaCapitulos = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $valid = self::isValid($id);

        if ($valid === true && $capitulo == "capitulo"){
            $query = "SELECT capitulos.titulo, capInicio, capFin FROM " . \ConstantesDB\ConsCapModel::TABLE_NAME .
                " INNER JOIN " . \ConstantesDB\ConsLibrosModel::TABLE_NAME . " ON capitulos.idLibro = libros.codigo";
        }

        if ($idCap == null) {
            $query = $query . " WHERE " . \ConstantesDB\ConsLibrosModel::COD . " = ?";
        }else{
            $query = $query . " WHERE " . \ConstantesDB\ConsCapModel::COD . " = ?";
        }

        $prep_query = $db_connection->prepare($query);

        if ($idCap == null) {
            $prep_query->bind_param('i', $id);
        }else{
            $prep_query->bind_param('i', $idCap);
        }

        $prep_query->execute();

        $prep_query->bind_result($titulo,$capInicio, $capFin);
        while ($prep_query->fetch()) {
            $titulo = utf8_encode($titulo);
            $capitulo = new CapitulosModel($titulo,$capInicio, $capFin);
            $listaCapitulos[] = $capitulo;
        }



        $db_connection->close();

        return sizeof($listaCapitulos)  == 1 ? $listaCapitulos[0] : $listaCapitulos ;
    }
    

    //PRACTICA LIBROS
    public static function getLibro($id, $query_string)
    {
        $listaLibros = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $valid = self::isValid($id);

        //If the $id is valid or the client asks for the collection ($id is null)
        if ($valid === true || $id == null) {
            if ($query_string == null){
                $query = "SELECT " . \ConstantesDB\ConsLibrosModel::COD . ","
                    . \ConstantesDB\ConsLibrosModel::TITULO . ","
                    . \ConstantesDB\ConsLibrosModel::PAGS . " FROM " . \ConstantesDB\ConsLibrosModel::TABLE_NAME;

                if ($id != null) {
                    $query = $query . " WHERE " . \ConstantesDB\ConsLibrosModel::COD . " = ?";
                }

            }else{

                if(isset($query_string['minpag']) && isset($query_string['maxpag']))
                {
                    $query="SELECT " . \ConstantesDB\ConsLibrosModel::COD . ","
                        . \ConstantesDB\ConsLibrosModel::TITULO . ","
                        . \ConstantesDB\ConsLibrosModel::PAGS . " FROM " . \ConstantesDB\ConsLibrosModel::TABLE_NAME." WHERE "
                        .\ConstantesDB\ConsLibrosModel::PAGS . ">=? and ".\ConstantesDB\ConsLibrosModel::PAGS."<=?";
                }
                else if(isset($query_string['minpag'])&&!isset($query_string['maxpag']))
                {
                    $query="SELECT " . \ConstantesDB\ConsLibrosModel::COD . ","
                        . \ConstantesDB\ConsLibrosModel::TITULO . ","
                        . \ConstantesDB\ConsLibrosModel::PAGS . " FROM " . \ConstantesDB\ConsLibrosModel::TABLE_NAME." WHERE "
                        .\ConstantesDB\ConsLibrosModel::PAGS . ">=?";
                }
                else if(!isset($query_string['minpag'])&&isset($query_string['maxpag']))
                {
                    $query="SELECT " . \ConstantesDB\ConsLibrosModel::COD . ","
                        . \ConstantesDB\ConsLibrosModel::TITULO . ","
                        . \ConstantesDB\ConsLibrosModel::PAGS . " FROM " . \ConstantesDB\ConsLibrosModel::TABLE_NAME." WHERE "
                        .\ConstantesDB\ConsLibrosModel::PAGS . "<=?";
                }
            }

            $prep_query = $db_connection->prepare($query);

            if ($id != null) {
                $prep_query->bind_param('s', $id);
            }
            else if($id==null&&$query_string!=null&&isset($query_string['minpag'])&&isset($query_string['maxpag']))
            {
                $minpag=$query_string['minpag'];
                $maxpag=$query_string['maxpag'];
                $prep_query->bind_param('ii',$minpag,$maxpag);
            }
            else if($id==null&&isset($query_string['minpag'])&&!isset($query_string['maxpag']))
            {
                $minpag=$query_string['minpag'];
                $prep_query->bind_param('i',$minpag);
            }
            else if($id==null&&!isset($query_string['minpag'])&&isset($query_string['maxpag']))
            {
                $maxpag=$query_string['maxpag'];
                $prep_query->bind_param('i',$maxpag);
            }

            $prep_query->execute();
            $listaLibros = array();

            //IMPORTANT: IN OUR SERVER, I COULD NOT USE EITHER GET_RESULT OR FETCH_OBJECT,
            // PHP VERSION WAS OK (5.4), AND MYSQLI INSTALLED.
            // PROBABLY THE PROBLEM IS THAT MYSQLND DRIVER IS NEEDED AND WAS NOT AVAILABLE IN THE SERVER:
            // http://stackoverflow.com/questions/10466530/mysqli-prepared-statement-unable-to-get-result

            $prep_query->bind_result($cod, $tit, $pag);
            while ($prep_query->fetch()) {
                $tit = utf8_encode($tit);
                $libro = new LibroModel($cod, $tit, $pag);
                $listaLibros[] = $libro;
            }

        }
        $db_connection->close();

        return sizeof($listaLibros) == 1 ? $listaLibros[0] : $listaLibros;
    }

    public static function postLibro($libro){

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "INSERT INTO libros(titulo, numpag) VALUES (?,?)";

        $prep_query = $db_connection->prepare($query);

        $prep_query->bind_param("si", $libro->titulo, $libro->numpag);

        $prep_query->execute();

        $filasAfectadas = $prep_query->affected_rows;

        $db_connection->close();

        return $filasAfectadas;

    }

    public static function deleteLibro($id){

        $filasAfectadas = 0;
        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $valid = self::isValid($id);

        if ($valid === true){

            $query = "DELETE FROM  " . \ConstantesDB\ConsLibrosModel::TABLE_NAME;

            $query = $query . " WHERE " . \ConstantesDB\ConsLibrosModel::COD . " = ?";

            $prep_query = $db_connection->prepare($query);
            $prep_query->bind_param('i', $id);

            $prep_query->execute();

            $filasAfectadas = $prep_query->affected_rows;

            $db_connection->close();

        }

        return $filasAfectadas;
    }

    public static function putLibro($libro){

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();

        $query = "Update libros SET titulo=?,numpag=? WHERE codigo=?";

        $prep_query = $db_connection->prepare($query);

        $id = $libro->codigo;
        $numpag = $libro->numpag;
        $titulo = $libro->titulo;

        $prep_query->bind_param('sii', $titulo, $numpag, $id);
        $prep_query->execute();

        $db_connection->close();

        return $prep_query->affected_rows;

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