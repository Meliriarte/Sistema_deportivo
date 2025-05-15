<?php
include("conexionBD.php");

// Validar que se recibieron los datos requeridos
if (!isset($_POST['evento_id']) || !isset($_POST['participante_id'])) {
    echo "Error: Faltan datos requeridos. <a href='inscripciones.php'>Volver</a>";
    exit;
}

// Sanitizar y convertir a enteros
$evento_id = intval($_POST['evento_id']);
$participante_id = intval($_POST['participante_id']);

// Validar que los IDs sean válidos
if ($evento_id <= 0 || $participante_id <= 0) {
    echo "Error: IDs inválidos. <a href='inscripciones.php'>Volver</a>";
    exit;
}

// Verificar que el evento exista y esté activo
$evento_check = mysqli_query($conex, "SELECT id, estado FROM eventos WHERE id = $evento_id");
if (mysqli_num_rows($evento_check) == 0) {
    echo "Error: El evento seleccionado no existe. <a href='inscripciones.php'>Volver</a>";
    exit;
}

$evento_data = mysqli_fetch_assoc($evento_check);
if ($evento_data['estado'] != 'activo') {
    echo "Error: El evento seleccionado no está activo. <a href='inscripciones.php'>Volver</a>";
    exit;
}

// Verificar que el participante exista y esté activo
$participante_check = mysqli_query($conex, "SELECT id, estado FROM participantes WHERE id = $participante_id");
if (mysqli_num_rows($participante_check) == 0) {
    echo "Error: El participante seleccionado no existe. <a href='inscripciones.php'>Volver</a>";
    exit;
}

$participante_data = mysqli_fetch_assoc($participante_check);
if (isset($participante_data['estado']) && $participante_data['estado'] != 'activo') {
    echo "Error: El participante seleccionado no está activo. <a href='inscripciones.php'>Volver</a>";
    exit;
}

// Verificar si el participante ya está inscrito en el evento
$verificar = mysqli_query($conex, "SELECT id FROM inscripciones WHERE evento_id = $evento_id AND participante_id = $participante_id AND estado = 'activa'");
if (mysqli_num_rows($verificar) > 0) {
    echo "<div style='text-align:center; padding:20px; background-color:#fcf8e3; border:1px solid #faebcc; margin:20px;'>
            <h3 style='color:#8a6d3b;'>Este participante ya está inscrito en el evento</h3>
            <p><a href='inscripciones.php'>Volver e intentar con otro participante</a></p>
          </div>";
    exit;
}

// Verificar si hay cupo disponible
$cupo_actual = mysqli_query($conex, "SELECT COUNT(*) AS inscritos FROM inscripciones WHERE evento_id = $evento_id AND estado = 'activa'");
$max_cupo = mysqli_query($conex, "SELECT max_participantes FROM eventos WHERE id = $evento_id");

$cupo = mysqli_fetch_assoc($cupo_actual)['inscritos'];
$max = mysqli_fetch_assoc($max_cupo)['max_participantes'];

if ($cupo >= $max) {
    echo "<div style='text-align:center; padding:20px; background-color:#fcf8e3; border:1px solid #faebcc; margin:20px;'>
            <h3 style='color:#8a6d3b;'>El evento ha alcanzado su cupo máximo</h3>
            <p><a href='inscripciones.php'>Volver e intentar con otro evento</a></p>
          </div>";
    exit;
}

// Realizar la inscripción
$sql = "INSERT INTO inscripciones (evento_id, participante_id, estado) VALUES ($evento_id, $participante_id, 'activa')";
if (mysqli_query($conex, $sql)) {
    echo "<div style='text-align:center; padding:20px; background-color:#dff0d8; border:1px solid #d6e9c6; margin:20px;'>
            <h3 style='color:#3c763d;'>Inscripción exitosa</h3>
            <p><a href='index.php'>Volver al inicio</a> | <a href='inscripciones.php'>Realizar otra inscripción</a></p>
          </div>";
} else {
    echo "<div style='text-align:center; padding:20px; background-color:#f2dede; border:1px solid #ebccd1; margin:20px;'>
            <h3 style='color:#a94442;'>Error al realizar la inscripción</h3>
            <p>" . mysqli_error($conex) . "</p>
            <p><a href='inscripciones.php'>Intentar nuevamente</a></p>
          </div>";
}
?>
