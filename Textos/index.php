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
$persona->set_Name("Sam");
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

        <form action="index.php">
            Name: <input type="text" name="name" value="<?php echo $nombre;?>">
            <?php echo "Tu nombre tiene ". $operaciones->cuentaPalabras($nombre) . " letras"?><br>
            Apellido: <input type="text" name="apellido" value="<?php echo $apellido;?>">
            <?php echo "Tu apellido tiene ". $operaciones->cuentaPalabras($apellido) . " letras"?><br>
            Telefono: <input type="text" name="telefono" value="<?php echo $telefono;?>">
            <?php echo "Tu telefono tiene ". $operaciones->cuentaPalabras($telefono) . " numeros"?><br>
            DNI: <input type="text" name="id" value="<?php echo $id;?>">
            <?php echo "Tu dni tiene ". $operaciones->cuentaPalabras($id) . " numeros"?>
        </form>

    </body>

</html>

