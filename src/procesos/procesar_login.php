<?php
/**
 * procesar_login.php
 * Versión simplificada para aceptar contraseñas tal cual están en la base de datos.
 * Ubicación: /src/procesos/procesar_login.php
 */

// 1. Iniciar Sesión
session_start();

// 2. Conexión a la DB (Necesaria para que funcione en la carpeta nueva)
require_once '../db/config_db.php'; 

// 3. Recoger datos
$correo = $_POST['email'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($correo) || empty($contrasena)) {
    header("Location: " . URL_ROOT . "/public/Login.html?error=camposvacios");
    exit;
}

// 4. Buscar usuario en la tabla 'usuario' (minúsculas, según tu captura)
$sql = "SELECT IDusuario, contrasena FROM usuario WHERE correo = :correo LIMIT 1"; 
$stmt = $conexion->prepare($sql);
$stmt->execute(['correo' => $correo]);
$usuario_db = $stmt->fetch();

// 5. Comparación DIRECTA (Sin seguridad moderna, solo funcionalidad)
if ($usuario_db) {
    // Compara el texto escrito directamente con el texto en la base de datos
    if ($contrasena === $usuario_db['contrasena']) {
        
        // ¡Éxito! Guardamos sesión
        $_SESSION['IDusuario'] = $usuario_db['IDusuario'];
        
        // Redirigimos a la principal usando la ruta correcta
        header("Location: " . URL_ROOT . "/public/Principal.php");
        exit();

    } else {
        header("Location: " . URL_ROOT . "/public/Login.html?error=contrasena");
        exit();
    }
} else {
    header("Location: " . URL_ROOT . "/public/Login.html?error=usuario");
    exit();
}
?>