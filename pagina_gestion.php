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
        <h1>Bienvenido a la pagina de gestiones</h1>
        
        <div class="botones">
          
        
             <a href="buscar_eventos.php"><button>Eventos</button></a>
             <a href="buscar_participantes.php"><button>participantes</button></a>
             <a href="buscar_inscripcion.php"><button>inscripciones</button></a>
              <a href="index.php"><button>Volver</button></a>
        </div>
    </div>
</body>
</html>
