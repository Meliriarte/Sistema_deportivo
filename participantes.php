<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participantes</title>
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background-color: #f0f0f0; font-family: 'Times New Roman', serif; text-align: center; }
        .container { padding: 20px; background: white; border: 1px solid #ccc; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Participantes</h1>
        <p>Gestión de participantes próximamente.</p>
        <form action="guardar_participante.php" method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Cédula:</label><br>
    <input type="text" name="cedula" required><br><br>

    <label>Fecha de nacimiento:</label><br>
    <input type="date" name="fecha_nacimiento" required><br><br>

    <label>Contacto:</label><br>
    <input type="text" name="contacto" required><br><br>

    <label>Equipo/Club (opcional):</label><br>
    <input type="text" name="equipo"><br><br>

    <input type="submit" value="Registrar Participante">
     <input type="button" value="Volver" onclick="window.location.href='index.php'" style="margin-left: 10px;">
</form>
    </div>
</body>
</html>
