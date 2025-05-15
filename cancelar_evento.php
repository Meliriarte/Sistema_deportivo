<?php
include("conexionBD.php");

// Validar que se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de evento inválido. <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

$id = intval($_GET['id']);

// Verificar que el evento existe
$check = mysqli_query($conex, "SELECT id FROM eventos WHERE id = $id");
if (mysqli_num_rows($check) == 0) {
    echo "El evento no existe. <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

$sql = "UPDATE eventos SET estado = 'cancelado' WHERE id = $id";

if (mysqli_query($conex, $sql)) {
    echo "<div style='text-align:center; padding:20px; background-color:#dff0d8; border:1px solid #d6e9c6; margin:20px;'>
            <h3 style='color:#3c763d;'>Evento cancelado correctamente</h3>
            <p><a href='buscar_eventos.php'>Volver a la lista de eventos</a></p>
          </div>";
} else {
    echo "<div style='text-align:center; padding:20px; background-color:#f2dede; border:1px solid #ebccd1; margin:20px;'>
            <h3 style='color:#a94442;'>Error al cancelar el evento</h3>
            <p>" . mysqli_error($conex) . "</p>
            <p><a href='buscar_eventos.php'>Volver e intentar nuevamente</a></p>
          </div>";
}
?>
