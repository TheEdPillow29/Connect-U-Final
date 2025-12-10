<?php
/**
 * verificar_sesion.php
 * Módulo de seguridad central.
 * Ubicación: /src/libs/verificar_sesion.php
 */

// 1. Inicia la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. CRÍTICO: Usar __DIR__ para que la ruta sea absoluta y funcione siempre.
// __DIR__ es la carpeta actual (src/libs). Salimos (..) y entramos a (db).
require_once __DIR__ . '/../db/config_db.php'; 

// 3. Obtiene el ID del usuario de la sesión
$IDusuario = $_SESSION['IDusuario'] ?? null;

// 4. Verifica si el ID de usuario existe
if (!$IDusuario) {
    // REDIRECCIÓN: Usamos la constante URL_ROOT definida en config_db.php
    header("Location: " . URL_ROOT . "/public/Login.html");
    exit; 
}
?>