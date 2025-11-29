<?php
/**
 * config_db.php
 * Se incluye la constante URL_ROOT para manejar redirecciones absolutas.
 */

// --- Credenciales y Configuración de Conexión ---
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3307');
define('DB_NAME', 'sistemagruposv2');
define('DB_USER', 'AdministradorWeb');
define('DB_PASS', 'h9!(pZ.P2GYYbFe/');

// --- CONSTANTE DE URL ABSOLUTA ---
// ESTA ES LA RUTA DE TU PROYECTO DESDE http://localhost/
// En src/db/config_db.php

// RUTA CORRECTA: EMPIEZA CON BARRA Y TERMINA SIN BARRA
define('URL_ROOT', '/ProyectoCoonectU'); 

// NO DEBE SER:
// define('URL_ROOT', 'ProyectoCoonectU');    <-- Faltaría la barra inicial
// define('URL_ROOT', '/ProyectoCoonectU/');  <-- Tendría una barra extra al final

$conexion = null; 

try {
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8';
    $conexion = new PDO($dsn, DB_USER, DB_PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error crítico al conectar con la base de datos: " . $e->getMessage());
}
?>