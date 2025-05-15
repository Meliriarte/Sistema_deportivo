<?php
// Parámetros de conexión - Asegúrate de que estos valores sean correctos
$host = "localhost";
$usuario = "root";
$password = ""; // Normalmente vacío en instalaciones XAMPP por defecto
$base_datos = "sistema_deportivo";

// Intentar conectar a la base de datos con manejo de errores mejorado
try {
    // Crear la conexión
    $conex = mysqli_connect($host, $usuario, $password, $base_datos);
    
    // Verificar la conexión
    if (!$conex) {
        throw new Exception(mysqli_connect_error());
    }
    
    // Establecer el conjunto de caracteres a utf8
    mysqli_set_charset($conex, "utf8");
    
} catch (Exception $e) {
    // Mostrar un mensaje de error más detallado
    die("<div style='color:red; font-family:Arial; padding:20px; border:1px solid #ffaaaa; background:#ffeeee;'>
        <h3>Error de conexión a la base de datos</h3>
        <p>" . $e->getMessage() . "</p>
        <p>Verifica que:</p>
        <ol>
            <li>El servidor MySQL esté funcionando en XAMPP (botón 'Start' en MySQL)</li>
            <li>La base de datos '$base_datos' exista</li>
            <li>El usuario '$usuario' tenga acceso a la base de datos</li>
            <li>La contraseña sea correcta</li>
        </ol>
        </div>");
}
?>
