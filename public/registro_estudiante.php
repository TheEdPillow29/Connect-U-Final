<?php
/**
 * registro_estudiante.php
 * Formulario de registro adaptado para guardar contraseñas en texto plano
 * y usar la tabla 'usuario' existente.
 * Ubicación: /public/registro_estudiante.php
 */

session_start();

// 1. Conexión centralizada (Ajusta la ruta si es necesario)
// Sube un nivel (..) para salir de 'public' y entra a 'src/db'
require_once '../src/db/config_db.php'; 

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $matricula = $_POST['matricula'] ?? ''; // Esto irá al campo IDusuario
    $correo = $_POST['correo'] ?? '';
    // $carrera = $_POST['carrera'] ?? ''; // OMITIDO: No aparece en tu tabla 'usuario'
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($contrasena !== $confirmar) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
    } else {
        // --- CAMBIO: SIN ENCRIPTACIÓN ---
        // Guardamos la contraseña tal cual para que el login simple funcione
        $clave_final = $contrasena; 

        // SQL ajustado a tu tabla 'usuario' (según tu captura de pantalla)
        // Mapeo: matricula -> IDusuario
        $sql = "INSERT INTO usuario (IDusuario, nombre, correo, contrasena)
                VALUES (:id, :nombre, :correo, :pass)";

        $stmt = $conexion->prepare($sql);

        try {
            $stmt->execute([
                ':id' => $matricula,
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':pass' => $clave_final
            ]);
            
            $_SESSION['exito'] = "Registro exitoso. ¡Inicia sesión ahora!";
            
            // Redirección absoluta usando URL_ROOT
            header("Location: " . URL_ROOT . "/public/Login.html");
            exit;

        } catch (PDOException $e) {
            // Manejo de errores (ej. ID duplicado)
            $error_msg = $e->getMessage();
            if (strpos($error_msg, 'Duplicate') !== false) {
                $_SESSION['error'] = "Error: La matrícula o correo ya están registrados.";
            } else {
                $_SESSION['error'] = "Error al registrar: " . $error_msg;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiantes</title>
    
    <!-- Ruta CSS corregida -->
    <link rel="stylesheet" href="../assets/css/Bonito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        
        <!-- Mensajes de Alerta -->
        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['exito']) ?></div>
            <?php unset($_SESSION['exito']); ?>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="card shadow-sm p-4 bg-white">
            <h3 class="text-center mb-4">📋 Registro de Estudiantes</h3>
            
            <!-- El formulario envía los datos a este mismo archivo -->
            <form method="post" action="">
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="matricula" class="form-label">Matrícula (ID Usuario)</label>
                    <input type="text" name="matricula" class="form-control" required placeholder="Ej: IRJ-12345">
                </div>
                
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo institucional</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>

                <!-- Campo Carrera omitido para evitar error de columna no encontrada -->
                
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="confirmar" class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="confirmar" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                
                <div class="mt-3 text-center">
                    <a href="Login.html">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>