<?php
/**
 * procesar_login.php
 * Ubicación: /src/procesos/procesar_login.php
 */

session_start();
require_once '../db/config_db.php'; 

$correo = $_POST['email'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($correo) || empty($contrasena)) {
    header("Location: " . URL_ROOT . "/public/Login.html?error=camposvacios");
    exit;
}

// 1. Buscar al usuario en la tabla general
$sql = "SELECT IDusuario, contrasena FROM usuario WHERE correo = :correo LIMIT 1"; 
$stmt = $conexion->prepare($sql);
$stmt->execute(['correo' => $correo]);
$usuario_db = $stmt->fetch();

if ($usuario_db) {
    // 2. Verificar contraseña (soportando migración de antiguas)
    $login_exitoso = false;
    $contrasena_almacenada = $usuario_db['contrasena'];

    if (password_verify($contrasena, $contrasena_almacenada)) {
        $login_exitoso = true;
    } elseif ($contrasena === $contrasena_almacenada) {
        $login_exitoso = true;
        // Migración automática a hash seguro
        $nuevo_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql_update = "UPDATE usuario SET contrasena = :hash WHERE IDusuario = :id";
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->execute(['hash' => $nuevo_hash, 'id' => $usuario_db['IDusuario']]);
    }

    if ($login_exitoso) {
        $_SESSION['IDusuario'] = $usuario_db['IDusuario'];
        $_SESSION['mensaje_exito'] = "¡Bienvenido!";

        // --- 3. LÓGICA DE ROLES (NUEVO) ---
        // Preguntamos: ¿Este ID está en la tabla de responsables?
        $sql_rol = "SELECT tipoResponsable FROM responsable WHERE IDusuario = :id LIMIT 1";
        $stmt_rol = $conexion->prepare($sql_rol);
        $stmt_rol->execute(['id' => $usuario_db['IDusuario']]);
        $es_responsable = $stmt_rol->fetch();

        if ($es_responsable) {
            // ¡ES UN JEFE! -> Va al panel de aprobación
            $_SESSION['rol'] = 'Responsable'; // Guardamos el rol por si acaso
            header("Location: " . URL_ROOT . "/public/panel_admin.php");
        } else {
            // ES UN ESTUDIANTE -> Va al panel normal
            $_SESSION['rol'] = 'Estudiante';
            header("Location: " . URL_ROOT . "/public/Principal.php");
        }
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