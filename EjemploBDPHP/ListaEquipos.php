<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <h2>Listado de Equipos</h2>
</head>
<body>
    <?php
        include "mostrarEquipos.php";
        $mostrar = new mostrarEquipos();
        $mostrar->cargarLista();
    ?>
    <form action="" method="post">
        <input type="submit">
    </form>
</body>
</html>