<?php
include("conexionBD.php");

$evento_id = $_GET['evento_id'] ?? '';

// Si se seleccionó un evento, buscar sus inscripciones
if (!empty($evento_id)) {
    $query_inscripciones = "SELECT i.id, p.nombre as participante_nombre, p.documento_identidad, 
                           e.nombre as evento_nombre, e.fecha, i.estado
                           FROM inscripciones i
                           JOIN participantes p ON i.participante_id = p.id
                           JOIN eventos e ON i.evento_id = e.id
                           WHERE i.evento_id = $evento_id
                           ORDER BY p.nombre";
    $result_inscripciones = mysqli_query($conex, $query_inscripciones);
}

// Obtener lista de eventos para el selector
$query_eventos = "SELECT id, nombre FROM eventos WHERE estado = 'activo'";
$result_eventos = mysqli_query($conex, $query_eventos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Inscripciones</title>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f0f0f0; margin: 0; padding: 0; display: flex; justify-content: center; }
        .container { margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 90%; max-width: 800px; }
        form { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; }
        label { width: 100%; margin-top: 10px; font-weight: bold; }
        select { width: 100%; padding: 5px; }
        input[type="submit"], .btn { width: auto; padding: 8px 15px; margin-top: 10px; cursor: pointer; border-radius: 5px; border: 1px solid #888; background: #ddd; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Buscar Inscripciones por Evento</h2>
        <form action="buscar_inscripcion.php" method="GET">
            <label>Seleccione un Evento:</label>
            <select name="evento_id" required>
                <option value="">Seleccione un evento</option>
                <?php while ($evento = mysqli_fetch_assoc($result_eventos)): ?>
                    <option value="<?= $evento['id'] ?>" <?= ($evento_id == $evento['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($evento['nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="Buscar Inscripciones">
            <input type="button" class="btn" value="Volver" onclick="window.location.href='pagina_gestion.php'">
        </form>

        <?php if (isset($result_inscripciones) && mysqli_num_rows($result_inscripciones) > 0): ?>
        <h3>Participantes Inscritos:</h3>
        <table>
            <thead>
                <tr>
                    <th>Participante</th>
                    <th>Documento</th>
                    <th>Evento</th>
                    <th>Fecha del Evento</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($inscripcion = mysqli_fetch_assoc($result_inscripciones)): ?>
                <tr>
                    <td><?= htmlspecialchars($inscripcion['participante_nombre']) ?></td>
                    <td><?= htmlspecialchars($inscripcion['documento_identidad']) ?></td>
                    <td><?= htmlspecialchars($inscripcion['evento_nombre']) ?></td>
                    <td><?= htmlspecialchars($inscripcion['fecha']) ?></td>
                    <td><?= htmlspecialchars($inscripcion['estado'] ?? 'activa') ?></td>
                    <td>
                        <a href="cancelar_inscripcion.php?id=<?= $inscripcion['id'] ?>" onclick="return confirm('¿Seguro que deseas cancelar esta inscripción?')">
                            <button class="btn">Cancelar Inscripción</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php elseif (isset($result_inscripciones)): ?>
            <p style="margin-top: 20px;">No hay participantes inscritos en este evento.</p>
        <?php endif; ?>
    </div>
</body>
</html>
