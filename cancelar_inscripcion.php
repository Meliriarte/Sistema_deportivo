<?php
include("conexionBD.php");

$id = $_GET['id'];

$sql = "UPDATE inscripciones SET estado = 'cancelada' WHERE id = $id";

if (mysqli_query($conex, $sql)) {
    echo "Inscripción cancelada correctamente. <a href='buscar_inscripcion.php'>Volver</a>";
} else {
    echo "Error al cancelar la inscripción: " . mysqli_error($conex);
}
?>
