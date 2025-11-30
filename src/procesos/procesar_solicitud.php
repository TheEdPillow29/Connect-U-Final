<?php
/**
 * procesar_solicitud.php
 * Ubicación: /src/procesos/procesar_solicitud.php
 */

// 1. Inclusiones (Rutas relativas dentro del servidor funcionan bien aquí)
require_once '../libs/verificar_sesion.php'; 
require_once '../db/config_db.php'; 

// 2. Procesar Datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación
    if (empty($_POST['ID_grupo']) || !isset($_POST['mensaje'])) {
        $_SESSION['mensaje_error'] = "⚠️ Faltan datos necesarios.";
        // 🛑 CORRECCIÓN: Usar URL_ROOT
        header("Location: " . URL_ROOT . "/public/Principal.php");
        exit;
    }

    $ID_grupo = $_POST['ID_grupo'];
    $mensaje = $_POST['mensaje'];
    $ID_solicitud = 'SOL-' . mt_rand(10000, 99999);
    $fecha = date('Y-m-d H:i:s');
    $estado = 'Pendiente';

    try {
        $sql = "INSERT INTO solicitudgrupo (ID_solicitud, IDusuario, ID_grupo, mensaje, fecha, estado)
                VALUES (:ids, :idu, :idg, :msj, :fecha, :est)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':ids' => $ID_solicitud,
            ':idu' => $IDusuario,
            ':idg' => $ID_grupo,
            ':msj' => $mensaje,
            ':fecha' => $fecha,
            ':est' => $estado
        ]);

        $_SESSION['mensaje_exito'] = "✅ Solicitud enviada exitosamente.";

        // 🛑 CORRECCIÓN: Usar URL_ROOT para ir a Mis Solicitudes
        header("Location: " . URL_ROOT . "/public/mis_solicitudes.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['mensaje_error'] = "Error al guardar: " . $e->getMessage();
        // 🛑 CORRECCIÓN: Usar URL_ROOT
        header("Location: " . URL_ROOT . "/public/Principal.php");
        exit;
    }
} else {
    // Acceso directo no permitido
    header("Location: " . URL_ROOT . "/public/Principal.php");
    exit;
}
?>