<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Eventos</title>
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background-color: #f0f0f0; font-family: 'Times New Roman', serif; text-align: center; }
        .container { padding: 20px; background: white; border: 1px solid #ccc; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Eventos</h1>
        <form action="guardar_evento.php" method="POST">
            <label>Nombre del Evento:</label><br>
            <input type="text" name="nombre" required><br><br>

            <label>Tipo de Evento:</label><br>
            <select name="tipo" required>
                <option value="Carreras">Carreras</option>
                <option value="Partidos">Partidos</option>
                <option value="Torneos">Torneos</option>
            </select><br><br>

            <label>Fecha del Evento:</label><br>
            <input type="date" name="fecha" required><br><br>

            <label>Lugar del Evento:</label><br>
            <input type="text" name="lugar" required><br><br>

            <label>Número máximo de participantes:</label><br>
            <input type="number" name="numero" required><br><br>

            <input type="submit" value="Registrar Evento"> 
             <input type="button" value="Volver" onclick="window.location.href='index.php'" style="margin-left: 10px;">
           
             
        </form>
    </div>
</body>
</html>
