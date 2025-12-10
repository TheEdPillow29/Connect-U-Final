<?php
require_once '../libs/verificar_sesion.php'; 
require_once '../db/config_db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_solicitud = $_POST['id_solicitud'];
    $accion = $_POST['accion'];

    // 1. Obtener datos de la solicitud para saber a quién y a qué grupo unir
    $sql = "SELECT IDusuario, ID_grupo FROM solicitudgrupo WHERE ID_solicitud = :id LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->execute(['id' => $id_solicitud]);
    $solicitud = $stmt->fetch();

    if ($solicitud) {
        $id_usuario_solicitante = $solicitud['IDusuario'];
        $id_grupo = $solicitud['ID_grupo'];

        try {
            $conexion->beginTransaction();

            if ($accion === 'aceptar') {
                // A. Cambiar estado a 'Aprobado'
                $sqlUpdate = "UPDATE solicitudgrupo SET estado = 'Aprobado' WHERE ID_solicitud = :id";
                $stmtUp = $conexion->prepare($sqlUpdate);
                $stmtUp->execute(['id' => $id_solicitud]);

                // B. INSERTAR EN MIEMBROS (¡Aquí se une oficialmente!)
                $id_miembro = 'MEM-' . mt_rand(10000, 99999);
                $sqlInsert = "INSERT INTO miembrosgrupos (ID_miembro, ID_usuario, ID_grupo) VALUES (:idmem, :iduser, :idgrupo)";
                $stmtIn = $conexion->prepare($sqlInsert);
                $stmtIn->execute([
                    ':idmem' => $id_miembro,
                    ':iduser' => $id_usuario_solicitante,
                    ':idgrupo' => $id_grupo
                ]);

                $_SESSION['mensaje_exito'] = "✅ Usuario aceptado en el grupo.";

            } elseif ($accion === 'rechazar') {
                // Solo cambiar estado a 'Rechazado'
                $sqlUpdate = "UPDATE solicitudgrupo SET estado = 'Rechazado' WHERE ID_solicitud = :id";
                $stmtUp = $conexion->prepare($sqlUpdate);
                $stmtUp->execute(['id' => $id_solicitud]);
                
                $_SESSION['mensaje_exito'] = "Solicitud rechazada.";
            }

            $conexion->commit();

        } catch (PDOException $e) {
            $conexion->rollBack();
            $_SESSION['mensaje_error'] = "Error: " . $e->getMessage();
        }
    }
}

header("Location: " . URL_ROOT . "/public/mis_grupos_creados.php");
exit;
?>