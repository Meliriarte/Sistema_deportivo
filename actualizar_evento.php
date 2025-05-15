<?php
include("conexionBD.php");

// Validar que se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de evento inválido. <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conex, "SELECT * FROM eventos WHERE id = $id");

if (!$query) {
    echo "Error en la consulta: " . mysqli_error($conex) . ". <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

$evento = mysqli_fetch_assoc($query);

if (!$evento) {
    echo "Evento no encontrado. <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar los datos de entrada
    $nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
    $tipo = mysqli_real_escape_string($conex, $_POST['tipo']);
    $fecha = mysqli_real_escape_string($conex, $_POST['fecha']);
    $lugar = mysqli_real_escape_string($conex, $_POST['lugar']);
    $max_participantes = intval($_POST['max_participantes']);

    // Validar datos
    if (empty($nombre) || empty($tipo) || empty($fecha) || empty($lugar) || $max_participantes <= 0) {
        echo "Error: Todos los campos son obligatorios y el máximo de participantes debe ser mayor que cero. <a href='javascript:history.back()'>Volver</a>";
        exit;
    }

    $update = "UPDATE eventos SET 
               nombre='$nombre', 
               tipo='$tipo', 
               fecha='$fecha', 
               lugar='$lugar', 
               max_participantes=$max_participantes 
               WHERE id=$id";

    if (mysqli_query($conex, $update)) {
        echo "<div style='text-align:center; padding:20px; background-color:#dff0d8; border:1px solid #d6e9c6; margin:20px;'>
                <h3 style='color:#3c763d;'>Evento actualizado correctamente</h3>
                <p><a href='buscar_eventos.php'>Volver a la lista de eventos</a></p>
              </div>";
        exit;
    } else {
        echo "<div style='text-align:center; padding:20px; background-color:#f2dede; border:1px solid #ebccd1; margin:20px;'>
                <h3 style='color:#a94442;'>Error al actualizar el evento</h3>
                <p>" . mysqli_error($conex) . "</p>
                <p><a href='javascript:history.back()'>Volver e intentar nuevamente</a></p>
              </div>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f0f0f0; margin: 0; padding: 0; display: flex; justify-content: center; }
        .container { margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 90%; max-width: 600px; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        input[type="submit"], input[type="button"] { width: auto; padding: 8px 15px; margin-top: 20px; cursor: pointer; border-radius: 5px; border: 1px solid #888; background: #ddd; }
        .buttons { display: flex; gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Evento</h2>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($evento['nombre']) ?>" required>

            <label>Tipo:</label>
            <select name="tipo" required>
                <option value="Carreras" <?= $evento['tipo'] == 'Carreras' ? 'selected' : '' ?>>Carreras</option>
                <option value="Partidos" <?= $evento['tipo'] == 'Partidos' ? 'selected' : '' ?>>Partidos</option>
                <option value="Torneos" <?= $evento['tipo'] == 'Torneos' ? 'selected' : '' ?>>Torneos</option>
            </select>

            <label>Fecha:</label>
            <input type="date" name="fecha" value="<?= $evento['fecha'] ?>" required>

            <label>Lugar:</label>
            <input type="text" name="lugar" value="<?= htmlspecialchars($evento['lugar']) ?>" required>

            <label>Máximo de Participantes:</label>
            <input type="number" name="max_participantes" value="<?= $evento['max_participantes'] ?>" min="1" required>

            <div class="buttons">
                <input type="submit" value="Guardar Cambios">
                <input type="button" value="Volver" onclick="window.location.href='buscar_eventos.php'">
            </div>
        </form>
    </div>
</body>
</html>
