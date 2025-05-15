<?php
include("conexionBD.php");

// Validar que se recibieron los datos
if (!isset($_POST['nombre']) || !isset($_POST['tipo']) || !isset($_POST['fecha']) || 
    !isset($_POST['lugar']) || !isset($_POST['numero'])) {
    echo "Error: Faltan datos requeridos. <a href='eventos.php'>Volver</a>";
    exit;
}

// Sanitizar los datos de entrada para prevenir SQL Injection
$nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
$tipo = mysqli_real_escape_string($conex, $_POST['tipo']);
$fecha = mysqli_real_escape_string($conex, $_POST['fecha']);
$lugar = mysqli_real_escape_string($conex, $_POST['lugar']);
$max_participantes = intval($_POST['numero']); // Convertir a entero

// Validar que el número máximo de participantes sea positivo
if ($max_participantes <= 0) {
    echo "Error: El número máximo de participantes debe ser mayor que cero. <a href='eventos.php'>Volver</a>";
    exit;
}

$sql = "INSERT INTO eventos (nombre, tipo, fecha, lugar, max_participantes, estado) 
        VALUES ('$nombre', '$tipo', '$fecha', '$lugar', $max_participantes, 'activo')";

if (mysqli_query($conex, $sql)) {
    echo "<div style='text-align:center; padding:20px; background-color:#dff0d8; border:1px solid #d6e9c6; margin:20px;'>
            <h3 style='color:#3c763d;'>Evento registrado correctamente</h3>
            <p><a href='index.php'>Volver al inicio</a> | <a href='eventos.php'>Registrar otro evento</a></p>
          </div>";
} else {
    echo "<div style='text-align:center; padding:20px; background-color:#f2dede; border:1px solid #ebccd1; margin:20px;'>
            <h3 style='color:#a94442;'>Error al registrar el evento</h3>
            <p>" . mysqli_error($conex) . "</p>
            <p><a href='eventos.php'>Intentar nuevamente</a></p>
          </div>";
}
?>
