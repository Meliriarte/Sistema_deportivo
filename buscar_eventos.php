<?php
include("conexionBD.php");

// Sanitizar los parámetros de búsqueda
$nombre = isset($_GET['nombre']) ? mysqli_real_escape_string($conex, $_GET['nombre']) : '';
$tipo = isset($_GET['tipo']) ? mysqli_real_escape_string($conex, $_GET['tipo']) : '';
$fecha = isset($_GET['fecha']) ? mysqli_real_escape_string($conex, $_GET['fecha']) : '';

// Construir la consulta SQL con condiciones seguras
$query = "SELECT * FROM eventos WHERE 1=1";
if (!empty($nombre)) {
    $query .= " AND nombre LIKE '%" . $nombre . "%'";
}
if (!empty($tipo)) {
    $query .= " AND tipo = '" . $tipo . "'";
}
if (!empty($fecha)) {
    $query .= " AND fecha = '" . $fecha . "'";
}

// Ordenar por fecha descendente (más recientes primero)
$query .= " ORDER BY fecha DESC";

$result = mysqli_query($conex, $query);
if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conex);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Eventos</title>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f0f0f0; margin: 0; padding: 0; display: flex; justify-content: center; }
        .container { margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 90%; max-width: 800px; }
        form { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; }
        label { width: 100%; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 5px; }
        input[type="submit"], .btn { width: auto; padding: 8px 15px; margin-top: 10px; cursor: pointer; border-radius: 5px; border: 1px solid #888; background: #ddd; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #eee; }
        .estado-activo { color: green; }
        .estado-cancelado { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Buscar Eventos</h2>
        <form action="buscar_eventos.php" method="GET">
            <label>Nombre del Evento:</label>
            <input type="text" name="nombre" placeholder="Nombre del evento" value="<?= htmlspecialchars($nombre) ?>">

            <label>Tipo de Evento:</label>
            <select name="tipo">
                <option value="">Seleccione</option>
                <option value="Carreras" <?= $tipo == "Carreras" ? "selected" : "" ?>>Carreras</option>
                <option value="Partidos" <?= $tipo == "Partidos" ? "selected" : "" ?>>Partidos</option>
                <option value="Torneos" <?= $tipo == "Torneos" ? "selected" : "" ?>>Torneos</option>
            </select>

            <label>Fecha:</label>
            <input type="date" name="fecha" value="<?= htmlspecialchars($fecha) ?>">

            <input type="submit" value="Buscar">
            <input type="button" class="btn" value="Volver" onclick="window.location.href='pagina_gestion.php'">
        </form>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <h3>Resultados:</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($evento = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($evento['nombre']) ?></td>
                    <td><?= htmlspecialchars($evento['tipo']) ?></td>
                    <td><?= htmlspecialchars($evento['fecha']) ?></td>
                    <td><?= htmlspecialchars($evento['lugar']) ?></td>
                    <td class="estado-<?= strtolower($evento['estado'] ?? 'activo') ?>">
                        <?= htmlspecialchars(ucfirst($evento['estado'] ?? 'activo')) ?>
                    </td>
                    <td>
                        <?php if ($evento['estado'] != 'cancelado'): ?>
                            <a href="actualizar_evento.php?id=<?= $evento['id'] ?>"><button class="btn">Actualizar</button></a>
                            <a href="registrar_resultado.php?id=<?= $evento['id'] ?>"><button class="btn">Resultados</button></a>
                            <a href="cancelar_evento.php?id=<?= $evento['id'] ?>" onclick="return confirm('¿Seguro que deseas cancelar este evento?')"><button class="btn">Cancelar</button></a>
                        <?php else: ?>
                            <span style="color:gray;">Evento cancelado</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p style="margin-top: 20px;">No se encontraron eventos con esos criterios.</p>
        <?php endif; ?>
    </div>
</body>
</html>
