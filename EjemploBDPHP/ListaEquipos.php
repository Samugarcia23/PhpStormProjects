<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <h2>Listado de Equipos</h2>
</head>
<body>
    <form action="" method="post">
        Equipo:
        <?php
            include "mostrarEquipos.php";
            $mostrar = new mostrarEquipos();
            $mostrar->cargarLista();
        ?>
        <br><br><input type="submit" value="Mas Info">
    </form>
</body>
</html>