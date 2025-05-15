<?php
include("conexionBD.php");

$nombre = $_GET['nombre'] ?? '';
$documento = $_GET['documento'] ?? '';

$query = "SELECT * FROM participantes WHERE nombre LIKE '%$nombre%' AND documento_identidad LIKE '%$documento%'";
$result = mysqli_query($conex, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Participantes</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Buscar Participantes</h2>
        <form action="buscar_participantes.php" method="GET">
            <label>Nombre del Participante:</label>
            <input type="text" name="nombre" placeholder="Nombre del participante" value="<?= htmlspecialchars($nombre) ?>">

            <label>Documento de Identidad:</label>
            <input type="text" name="documento" placeholder="Documento de identidad" value="<?= htmlspecialchars($documento) ?>">

            <input type="submit" value="Buscar">
            <input type="button" class="btn" value="Volver" onclick="window.location.href='pagina_gestion.php'">
        </form>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <h3>Resultados:</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Fecha Nacimiento</th>
                    <th>Contacto</th>
                    <th>Equipo/Club</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($participante = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($participante['nombre']) ?></td>
                    <td><?= htmlspecialchars($participante['documento_identidad']) ?></td>
                    <td><?= htmlspecialchars($participante['fecha_nacimiento']) ?></td>
                    <td><?= htmlspecialchars($participante['contacto']) ?></td>
                    <td><?= htmlspecialchars($participante['equipo_club']) ?></td>
                    <td><?= htmlspecialchars($participante['estado'] ?? 'activo') ?></td>
                    <td>
                        <a href="actualizar_participante.php?id=<?= $participante['id'] ?>"><button class="btn">Actualizar</button></a>
                        <a href="dar_baja_participante.php?id=<?= $participante['id'] ?>" onclick="return confirm('¿Seguro que deseas dar de baja a este participante?')"><button class="btn">Dar de baja</button></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p style="margin-top: 20px;">No se encontraron participantes con esos criterios.</p>
        <?php endif; ?>
    </div>
</body>
</html>
