<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'vercetti_properties';
$username = 'root';  // Cambia según tu configuración
$password = '';      // Cambia según tu configuración

try {
    // Crear conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar para que devuelva arrays asociativos por defecto
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
