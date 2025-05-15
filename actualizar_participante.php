<?php
include("conexionBD.php");

$id = $_GET['id'];
$query = mysqli_query($conex, "SELECT * FROM participantes WHERE id = $id");
$participante = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $fecha = $_POST['fecha_nacimiento'];
    $contacto = $_POST['contacto'];
    $equipo = $_POST['equipo'];

    $update = "UPDATE participantes SET 
               nombre='$nombre', 
               documento_identidad='$documento', 
               fecha_nacimiento='$fecha', 
               contacto='$contacto', 
               equipo_club='$equipo' 
               WHERE id=$id";

    if (mysqli_query($conex, $update)) {
        echo "Participante actualizado correctamente. <a href='buscar_participantes.php'>Volver</a>";
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($conex);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Participante</title>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f0f0f0; margin: 0; padding: 0; display: flex; justify-content: center; }
        .container { margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 90%; max-width: 600px; }
        form { display: flex; flex-direction: column; }
        label { margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        input[type="submit"], input[type="button"] { width: auto; padding: 8px 15px; margin-top: 20px; cursor: pointer; border-radius: 5px; border: 1px solid #888; background: #ddd; }
        .buttons { display: flex; gap: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Participante</h2>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($participante['nombre']) ?>" required>

            <label>Documento de Identidad:</label>
            <input type="text" name="documento" value="<?= htmlspecialchars($participante['documento_identidad']) ?>" required>

            <label>Fecha de Nacimiento:</label>
            <input type="date" name="fecha_nacimiento" value="<?= $participante['fecha_nacimiento'] ?>" required>

            <label>Contacto:</label>
            <input type="text" name="contacto" value="<?= htmlspecialchars($participante['contacto']) ?>" required>

            <label>Equipo/Club:</label>
            <input type="text" name="equipo" value="<?= htmlspecialchars($participante['equipo_club']) ?>">

            <div class="buttons">
                <input type="submit" value="Guardar Cambios">
                <input type="button" value="Volver" onclick="window.location.href='buscar_participantes.php'">
            </div>
        </form>
    </div>
</body>
</html>
