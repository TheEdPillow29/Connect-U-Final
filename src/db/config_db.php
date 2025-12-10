<?php
/**
 * config_db.php
 * Archivo de configuración central.
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306'); 
define('DB_NAME', 'sistemagruposv2');
define('DB_USER', 'root');
define('DB_PASS', '');

// 🛑 CORRECCIÓN CRÍTICA AQUÍ 🛑
// Debe ser solo la carpeta del proyecto, SIN '/src' al final.
define('URL_ROOT', '/ProyectoCoonectU'); 

$conexion = null; 

try {
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8';
    $conexion = new PDO($dsn, DB_USER, DB_PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error crítico de base de datos: " . $e->getMessage());
}
?>