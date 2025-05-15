<?php
include("conexionBD.php");

$id = $_GET['id'];

$sql = "UPDATE participantes SET estado = 'inactivo' WHERE id = $id";

if (mysqli_query($conex, $sql)) {
    echo "Participante dado de baja correctamente. <a href='buscar_participantes.php'>Volver</a>";
} else {
    echo "Error al dar de baja al participante: " . mysqli_error($conex);
}
?>
