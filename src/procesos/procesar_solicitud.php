<?php
/**
 * procesar_solicitud.php
 * Procesa el formulario de solicitud de ingreso a un grupo y registra el estado 'Pendiente' en la BD.
 * Ubicación: /src/procesos/procesar_solicitud.php
 */

// 1. MODULO DE SEGURIDAD: Inicia sesión, verifica la autenticación y nos provee $IDusuario.
// Sube un nivel (..) para entrar a 'src/libs'
include '../libs/verificar_sesion.php'; 

// 2. MODULO DE CONEXIÓN: Conecta con la DB. Nos provee $conexion.
// Sube un nivel (..) para entrar a 'src/db'
include '../db/config_db.php'; 

// La variable $IDusuario y $conexion ya están disponibles

// 3. PROCESAR DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación de datos mínimos
    if (empty($_POST['ID_grupo']) || !isset($_POST['mensaje'])) {
        // En lugar de die(), usamos la redirección con mensaje de error de sesión
        $_SESSION['mensaje_error'] = "⚠️ Faltan datos necesarios para enviar la solicitud.";
        header("Location: ../public/Principal.php");
        exit;
    }

    $ID_grupo = $_POST['ID_grupo'];
    $mensaje = $_POST['mensaje'];

    // Generar ID de solicitud con el formato IRN-XXXXX
    $numero_aleatorio = mt_rand(10000, 99999);
    $ID_solicitud = 'IRN-' . $numero_aleatorio;

    $fecha = date('Y-m-d H:i:s'); // Usar fecha y hora para mayor precisión
    $estado = 'Pendiente';

    try {
        // 4. Preparar e insertar la solicitud (uso de $conexion centralizado)
        $sql = "INSERT INTO solicitudgrupo (ID_solicitud, IDusuario, ID_grupo, mensaje, fecha, estado)
                VALUES (:ID_solicitud, :IDusuario, :ID_grupo, :mensaje, :fecha, :estado)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':ID_solicitud' => $ID_solicitud,
            ':IDusuario' => $IDusuario,
            ':ID_grupo' => $ID_grupo,
            ':mensaje' => $mensaje,
            ':fecha' => $fecha,
            ':estado' => $estado
        ]);

        // 5. Guardar un mensaje de éxito para mostrar en Principal.php
        $_SESSION['mensaje_exito'] = "✅ Tu solicitud fue enviada al administrador del grupo con éxito.";

        // Redirigir a la página principal (RUTA AJUSTADA)
        header("Location: ../public/Principal.php");
        exit;

    } catch (PDOException $e) {
        // Manejo de error de base de datos
        $_SESSION['mensaje_error'] = "❌ Error al guardar la solicitud: " . $e->getMessage();
        header("Location: ../public/Principal.php");
        exit;
    }
} else {
    // Si no es un POST (acceso directo), redirigir a la página principal (RUTA AJUSTADA)
    header("Location: ../public/Principal.php");
    exit;
}
?>