<?php
/**
 * logout.php
 * Ubicación: /src/procesos/logout.php
 */

// 1. Iniciar sesión para poder destruirla
session_start();

// 2. Incluir configuración para obtener URL_ROOT (CRUCIAL PARA LA REDIRECCIÓN)
require_once '../db/config_db.php';

// 3. Limpiar variables de sesión
$_SESSION = array();

// 4. Borrar la cookie de sesión del navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 5. Destruir la sesión en el servidor
session_destroy();

// 6. REDIRECCIÓN ABSOLUTA (La solución al error 404)
// Usamos URL_ROOT para ir directamente a la raíz del proyecto y luego a public/Login.html
header("Location: " . URL_ROOT . "/public/Login.html");
exit;
?>