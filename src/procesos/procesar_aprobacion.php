<?php
/**
 * procesar_aprobacion.php
 * Ubicación: /src/procesos/procesar_aprobacion.php
 * Función: Recibe la decisión del docente y actualiza el estado del grupo.
 */

// 1. Seguridad: Verificar sesión y ROL
require_once '../libs/verificar_sesion.php'; 
require_once '../db/config_db.php'; 

// Si no es responsable, fuera de aquí
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Responsable') {
    header("Location: " . URL_ROOT . "/public/Principal.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_grupo = $_POST['ID_grupo'] ?? '';
    $accion = $_POST['accion'] ?? ''; // 'aprobar' o 'rechazar'
    $fecha_hoy = date('Y-m-d');

    if ($id_grupo && $accion) {
        try {
            $conexion->beginTransaction();

            if ($accion === 'aprobar') {
                // 1. Cambiar estado del grupo a ACTIVO (Ahora será visible en Principal)
                $sql = "UPDATE Grupo SET estado = 'Activo' WHERE ID_grupo = :id";
                $stmt = $conexion->prepare($sql);
                $stmt->execute(['id' => $id_grupo]);

                // 2. Actualizar registro de validación
                $sql_val = "UPDATE validacion SET estadoValidacion = 'Aprobado', fechaValidacion = :fecha, ID_responsable = :admin 
                            WHERE ID_grupo = :id";
                $stmt_val = $conexion->prepare($sql_val);
                $stmt_val->execute(['fecha' => $fecha_hoy, 'admin' => $IDusuario, 'id' => $id_grupo]);

                $_SESSION['mensaje_exito'] = "✅ Grupo aprobado y publicado exitosamente.";

            } elseif ($accion === 'rechazar') {
                // Opción A: Borrar el grupo (Limpieza total)
                // Opción B: Marcar como 'Rechazado' (Historial) -> Usaremos esta
                
                $sql = "UPDATE Grupo SET estado = 'Rechazado' WHERE ID_grupo = :id";
                $stmt = $conexion->prepare($sql);
                $stmt->execute(['id' => $id_grupo]);

                $sql_val = "UPDATE validacion SET estadoValidacion = 'Rechazado', fechaValidacion = :fecha, ID_responsable = :admin 
                            WHERE ID_grupo = :id";
                $stmt_val = $conexion->prepare($sql_val);
                $stmt_val->execute(['fecha' => $fecha_hoy, 'admin' => $IDusuario, 'id' => $id_grupo]);

                $_SESSION['mensaje_exito'] = "❌ El grupo ha sido rechazado.";
            }

            $conexion->commit();

        } catch (PDOException $e) {
            $conexion->rollBack();
            $_SESSION['mensaje_error'] = "Error al procesar: " . $e->getMessage();
        }
    }
}

// Volver al panel de administración
header("Location: " . URL_ROOT . "/public/panel_admin.php");
exit;
?>