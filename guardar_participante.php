<?php
include("conexionBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que se recibieron los datos requeridos
    if (!isset($_POST['nombre']) || !isset($_POST['cedula']) || !isset($_POST['fecha_nacimiento']) || !isset($_POST['contacto'])) {
        echo "Error: Faltan datos requeridos. <a href='participantes.php'>Volver</a>";
        exit;
    }
    
    // Sanitizar los datos de entrada
    $nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
    $documento = mysqli_real_escape_string($conex, $_POST['cedula']); 
    $fecha = mysqli_real_escape_string($conex, $_POST['fecha_nacimiento']);
    $contacto = mysqli_real_escape_string($conex, $_POST['contacto']);
    $equipo = isset($_POST['equipo']) ? mysqli_real_escape_string($conex, $_POST['equipo']) : '';

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($documento) || empty($fecha) || empty($contacto)) {
        echo "Error: Todos los campos marcados son obligatorios. <a href='participantes.php'>Volver</a>";
        exit;
    }
    
    // Verificar si ya existe un participante con el mismo documento
    $check = mysqli_query($conex, "SELECT id FROM participantes WHERE documento_identidad = '$documento'");
    if (mysqli_num_rows($check) > 0) {
        echo "<div style='text-align:center; padding:20px; background-color:#fcf8e3; border:1px solid #faebcc; margin:20px;'>
                <h3 style='color:#8a6d3b;'>Ya existe un participante con este documento de identidad</h3>
                <p><a href='participantes.php'>Volver e intentar con otro documento</a></p>
              </div>";
        exit;
    }
    
    // Insertar el nuevo participante
    $sql = "INSERT INTO participantes (nombre, documento_identidad, fecha_nacimiento, contacto, equipo_club, estado) 
            VALUES ('$nombre', '$documento', '$fecha', '$contacto', '$equipo', 'activo')";

    if (mysqli_query($conex, $sql)) {
        echo "<div style='text-align:center; padding:20px; background-color:#dff0d8; border:1px solid #d6e9c6; margin:20px;'>
                <h3 style='color:#3c763d;'>Participante registrado correctamente</h3>
                <p><a href='index.php'>Volver al inicio</a> | <a href='participantes.php'>Registrar otro participante</a></p>
              </div>";
    } else {
        echo "<div style='text-align:center; padding:20px; background-color:#f2dede; border:1px solid #ebccd1; margin:20px;'>
                <h3 style='color:#a94442;'>Error al registrar participante</h3>
                <p>" . mysqli_error($conex) . "</p>
                <p><a href='participantes.php'>Intentar nuevamente</a></p>
              </div>";
    }
} else {
    // Si se accede directamente a este archivo sin enviar el formulario
    header("Location: participantes.php");
    exit;
}
?>
