<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de eventos deportivos</title>
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background-color: #f0f0f0; font-family: 'Times New Roman', serif; text-align: center; }
        .container { padding: 20px; background: white; border: 1px solid #ccc; border-radius: 10px; }
        .botones { margin-top: 20px; }
        .botones a { text-decoration: none; margin: 0 10px; }
        .botones button { padding: 10px 15px; cursor: pointer; border: 1px solid #333; border-radius: 5px; background-color: #eaeaea; font-family: 'Times New Roman', serif; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido al sistema de eventos deportivos</h1>
        <p>Aquí podrás gestionar eventos, participantes e inscripciones.</p>
        <div class="botones">
            <a href="eventos.php"><button>Registra tu evento</button></a>
            <a href="participantes.php"><button>Registrar participantes</button></a>
            <a href="inscripciones.php"><button>Registrar Inscripciones</button></a>
            <a href="pagina_gestion.php"><button>Gestion de eventos</button></a>
             
             
        </div>
    </div>
</body>
</html>
