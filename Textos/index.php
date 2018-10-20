<?php
/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 19/10/18
 * Time: 8:35
 */
include "Persona.php";
include "Operaciones.php";

$operaciones = new Operaciones();
$persona = new Persona();
$persona->set_Name("Samuel");
$persona->set_Apellido("Garcia");
$persona->set_Telefono("911255865");
$persona->set_Id("08756691");

$nombre=$persona->get_Name();
$apellido=$persona->get_Apellido();
$telefono=$persona->get_Telefono();
$id=$persona->get_Id();


?>

<html>

    <head><b>Prueba de Clases en PHP</b></head>

    <body>

        <form action="index.php" method="post">
            Name: <input type="text" name="name" value="<?php echo $nombre;?>">
            <b><?php echo "<br><br>Tu nombre tiene ". $operaciones->cuentaPalabras($nombre) . " letras"?><br></b>
            <br><br>Apellido: <input type="text" name="apellido" value="<?php echo $apellido;?>">
            <b><?php echo "<br><br>Tu apellido tiene ". $operaciones->cuentaPalabras($apellido) . " letras"?><br></b>
            <br><br>Telefono: <input type="text" name="telefono" value="<?php echo $telefono;?>">
            <b><?php echo "<br><br>Tu telefono tiene ". $operaciones->cuentaPalabras($telefono) . " numeros"?><br></b>
            <br><br>DNI: <input type="text" name="id" value="<?php echo $id;?>">
            <b><?php echo "<br><br>Tu dni tiene ". $operaciones->cuentaPalabras($id) . " numeros"?><br></b>

            <p>-----------------------------------------------------------------------------------</p><br>

            <a><b>Buscador de Letras: </b></a> <br><br>
            Letra a Buscar: <input type="text" name="txtBuscar">
            <input type="submit" name="btnBuscar" value="Buscar" /><br>
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['btnBuscar'])) {
                    if ( ! empty($_POST['txtBuscar'])){
                        $letra = $_POST['txtBuscar'];
                    }
                    echo "<br><br>Nombre: ";
                    $operaciones->posicion($letra, $nombre);
                    echo "<br><br>Apellido: ";
                    $operaciones->posicion($letra, $apellido);
                }
            }?>

            <p>-----------------------------------------------------------------------------------</p><br>

            <a><b>Sustituir Letras: </b></a><br><br>
            Letra a sustituir: <input type="text" name="txtSustituir"><br>
            <br><br>Letra sustituta: <input type="text" name="txtSustituta"><br>
            <br><br>Selecciona un campo para empezar a sustituir:<br>

            <br><br><select name="opcion">
                <option value="nom">Nombre</option>
                <option value="ape">Apellido</option>
            </select>

            <input type="submit" name="btnSustituir" value="Sustituir" /><br>

            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['btnSustituir'])) {

                    switch($_POST['opcion']){
                        case 'nom':
                            if ( ! empty($_POST['txtSustituir']) && ! empty($_POST['txtSustituta'])){
                                $sustituir = $_POST['txtSustituir'];
                                $sustituta = $_POST['txtSustituta'];
                            }
                            $operaciones->sustitucion($sustituir, $sustituta, $nombre);
                            break;
                        case 'ape':
                            if ( ! empty($_POST['txtSustituir']) && ! empty($_POST['txtSustituta'])){
                                $sustituir = $_POST['txtSustituir'];
                                $sustituta = $_POST['txtSustituta'];
                            }
                            $operaciones->sustitucion($sustituir, $sustituta, $apellido);
                            break;
                    }
                }
            }?>

        </form>

    </body>

</html>

