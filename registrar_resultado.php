<?php
include("conexionBD.php");

// Validar que se recibió un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de evento inválido. <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

$id_evento = intval($_GET['id']);

// Verificar que el evento exista
$query = mysqli_query($conex, "SELECT nombre, estado FROM eventos WHERE id = $id_evento");
if (!$query || mysqli_num_rows($query) == 0) {
    echo "Evento no encontrado. <a href='buscar_eventos.php'>Volver</a>";
    exit;
}

$evento = mysqli_fetch_assoc($query);

// Verificar que el evento no esté cancelado
if ($evento['estado'] == 'cancelado') {
    echo "<div style='text-align:center; padding:20px; background-color:#fcf8e3; border:1px solid #faebcc; margin:20px;'>
            <h3 style='color:#8a6d3b;'>No se pueden registrar resultados para un evento cancelado</h3>
            <p><a href='buscar_eventos.php'>Volver a la lista de eventos</a></p>
          </div>";
    exit;
}

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que se recibió el resultado
    if (!isset($_POST['resultado']) || empty($_POST['resultado'])) {
        echo "Error: El resultado no puede estar vacío. <a href='javascript:history.back()'>Volver</a>";
        exit;
    }
    
    // Sanitizar el resultado
    $resultado = mysqli_real_escape_string($conex, $_POST['resultado']);
    
    // Actualizar el resultado del evento
    $sql = "UPDATE eventos SET resultado = '$resultado' WHERE id = $id_evento";

    if (mysqli_query($conex, $sql)) {
        echo "<div style='padding: 20px; font-family: Arial; background-color: #e0ffe0; border: 1px solid #0a0; width: 80%; margin: 30px auto; text-align: center;'>
                <h3>Resultado registrado correctamente</h3>
                <p><a href='buscar_eventos.php'>Volver a la lista de eventos</a></p>
              </div>";
    } else {
        echo "<div style='color: red; text-align: center; padding: 20px;'>
                <h3>Error al registrar resultado</h3>
                <p>" . mysqli_error($conex) . "</p>
                <p><a href='javascript:history.back()'>Volver e intentar nuevamente</a></p>
              </div>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Resultado</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 600px;
            text-align: center;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #999;
            border-radius: 5px;
            resize: vertical;
        }
        input[type="submit"], input[type="button"] {
            padding: 8px 15px;
            margin-top: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #eaeaea;
            cursor: pointer;
            font-family: 'Times New Roman', serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrar Resultado para: <?= htmlspecialchars($evento['nombre']) ?></h2>
        <form method="POST">
            <label>Resultado del Evento:</label><br>
            <textarea name="resultado" rows="5" placeholder="Ej. Ganador: Club A, Tiempo: 1:10:32" required></textarea><br>
            <input type="submit" value="Guardar Resultado">
            <input type="button" value="Volver" onclick="window.location.href='buscar_eventos.php'">
        </form>
    </div>
</body>
</html>
