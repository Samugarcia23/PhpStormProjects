<?php

require_once "ConsLibrosModel.php"; //Consultas a la BBDD


class LibroHandlerModel
{
    public static function getLibro($id, $query_string)
    {
        $listaLibros = null;

        $db = DatabaseModel::getInstance();
        $db_connection = $db->getConnection();


        //IMPORTANT: we have to be very careful about automatic data type conversions in MySQL.
        //For example, if we have a column named "cod", whose type is int, and execute this query:
        //SELECT * FROM table WHERE cod = "3yrtdf"
        //it will be converted into:
        //SELECT * FROM table WHERE cod = 3
        //That's the reason why I decided to create isValid method,
        //I had problems when the URI was like libro/2jfdsyfsd

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

    /*
     * Busquedas especificas (query)
     *
     * else if(isset($query_string['minpag'])&&isset($query_string['maxpag']))
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
     */


    //returns true if $id is a valid id for a book
    //In this case, it will be valid if it only contains
    //numeric characters, even if this $id does not exist in
    // the table of books
    public static function isValid($id)
    {
        $res = false;

        if (ctype_digit($id)) {
            $res = true;
        }
        return $res;
    }

}