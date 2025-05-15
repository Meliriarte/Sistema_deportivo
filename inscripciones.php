<?php
include("conexionBD.php");

$result_eventos = mysqli_query($conex, "SELECT id, nombre FROM eventos WHERE estado='activo'");
$result_participantes = mysqli_query($conex, "SELECT id, nombre FROM participantes WHERE estado='activo'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción a Eventos</title>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f0f0f0; margin: 0; padding: 0; display: flex; justify-content: center; }
        .container { margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 90%; max-width: 600px; }
        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-weight: bold; }
        select, input[type="submit"], input[type="button"] { padding: 8px; font-family: inherit; }
        .btns { display: flex; justify-content: space-between; gap: 10px; }
        input[type="submit"], input[type="button"] { cursor: pointer; border-radius: 5px; border: 1px solid #888; background: #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscribir Participante a Evento</h2>
        <form action="guardar_inscripcion.php" method="POST">
            <label>Participante:</label>
            <select name="participante_id" required>
                <option value="">Seleccione un participante</option>
                <?php while($p = mysqli_fetch_assoc($result_participantes)): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Evento:</label>
            <select name="evento_id" required>
                <option value="">Seleccione un evento</option>
                <?php while($e = mysqli_fetch_assoc($result_eventos)): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nombre']) ?></option>
                <?php endwhile; ?>
            </select>

            <div class="btns">
                <input type="submit" value="Inscribir">
                <input type="button" value="Volver" onclick="window.location.href='index.php'">
            </div>
        </form>
    </div>
</body>
</html>
