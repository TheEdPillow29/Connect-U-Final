<?php
/**
 * procesar_eliminar_miembro.php
 * Permite al administrador expulsar a un miembro de su grupo.
 */

require_once '../libs/verificar_sesion.php'; 
require_once '../db/config_db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_grupo = $_POST['id_grupo'] ?? '';
    $id_usuario_a_eliminar = $_POST['id_usuario'] ?? '';

    if ($id_grupo && $id_usuario_a_eliminar) {
        // 1. SEGURIDAD: Verificar que YO ($IDusuario) soy el dueño del grupo
        $sqlCheck = "SELECT administradorGrupo FROM Grupo WHERE ID_grupo = :idg";
        $stmtCheck = $conexion->prepare($sqlCheck);
        $stmtCheck->execute(['idg' => $id_grupo]);
        $grupo = $stmtCheck->fetch();

        if ($grupo && $grupo['administradorGrupo'] === $IDusuario) {
            
            // 2. EJECUTAR ELIMINACIÓN
            try {
                $conexion->beginTransaction();

                // Borrar de la tabla miembros
                $sqlDel = "DELETE FROM miembrosgrupos WHERE ID_grupo = :idg AND ID_usuario = :idu";
                $stmtDel = $conexion->prepare($sqlDel);
                $stmtDel->execute(['idg' => $id_grupo, 'idu' => $id_usuario_a_eliminar]);

                // Opcional: También podríamos querer actualizar el estado de la solicitud a 'Expulsado' o borrarla,
                // pero borrar el miembro es suficiente para quitarle acceso.

                $conexion->commit();
                $_SESSION['mensaje_exito'] = "Miembro expulsado correctamente.";

            } catch (PDOException $e) {
                $conexion->rollBack();
                // En producción no mostrarías el error técnico
            }
        }
    }
}

// Volver al panel
header("Location: " . URL_ROOT . "/public/mis_grupos_creados.php");
exit;
?>