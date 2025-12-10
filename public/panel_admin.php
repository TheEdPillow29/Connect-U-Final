<?php
/**
 * panel_admin.php
 * Vista exclusiva para Responsables. Permite aprobar grupos de voluntariado.
 * Ubicación: /public/panel_admin.php
 */

require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

// Seguridad extra: Si intenta entrar un estudiante, lo echamos fuera
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Responsable') {
    header("Location: Principal.php");
    exit;
}

// Consulta: Traer solo grupos PENDIENTES de validación (Voluntariado)
$sql = "
SELECT 
    g.ID_grupo, g.nombreGrupo, g.descripcion, g.fecha,
    gv.OrganismoReceptor, gv.LugarActividad,
    u.nombre AS Creador
FROM Grupo g
INNER JOIN grupovoluntariado gv ON g.ID_grupo = gv.ID_grupo
INNER JOIN usuario u ON g.administradorGrupo = u.IDusuario
WHERE g.estado = 'Pendiente'
ORDER BY g.fecha ASC
";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$pendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración | Connect-U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Usamos tu CSS Bonito -->
    <link rel="stylesheet" href="../assets/css/Bonito.css">
    <style>
        .admin-header { background-color: #2c3e50; color: white; padding: 20px; }
        .card-revision { border-left: 5px solid #ffc107; } /* Borde amarillo de 'Pendiente' */
    </style>
</head>
<body style="display: block; background-color: #f4f6f9;">

    <div class="admin-header d-flex justify-content-between align-items-center mb-4">
        <h3 class="m-0">🛡️ Panel de Validación Institucional</h3>
        <a href="../src/procesos/logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
    </div>

    <div class="container">
        
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="alert alert-success"><?= $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></div>
        <?php endif; ?>

        <h4 class="mb-4 text-muted">Solicitudes Pendientes de Aprobación</h4>

        <?php if (count($pendientes) === 0): ?>
            <div class="alert alert-success text-center p-5">
                <h4>¡Todo al día! ✅</h4>
                <p>No hay grupos de voluntariado pendientes de revisión.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($pendientes as $p): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card card-revision shadow-sm h-100">
                            <div class="card-body">
                                <span class="badge bg-warning text-dark mb-2">Pendiente</span>
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($p['nombreGrupo']) ?></h5>
                                <h6 class="card-subtitle mb-3 text-muted">Solicitante: <?= htmlspecialchars($p['Creador']) ?></h6>
                                
                                <p class="card-text bg-light p-3 rounded">
                                    <em><?= nl2br(htmlspecialchars($p['descripcion'])) ?></em>
                                </p>
                                
                                <ul class="list-unstyled small text-secondary">
                                    <li><strong>🏢 Organismo:</strong> <?= htmlspecialchars($p['OrganismoReceptor']) ?></li>
                                    <li><strong>📍 Lugar:</strong> <?= htmlspecialchars($p['LugarActividad']) ?></li>
                                    <li><strong>📅 Fecha Solicitud:</strong> <?= $p['fecha'] ?></li>
                                </ul>

                                <hr>
                                <div class="d-grid gap-2">
                                    <!-- Este botón debería llamar a un script 'procesar_aprobacion.php' (Pendiente de crear) -->
                                    <form action="../src/procesos/procesar_aprobacion.php" method="POST">
                                        <input type="hidden" name="ID_grupo" value="<?= $p['ID_grupo'] ?>">
                                        <button type="submit" name="accion" value="aprobar" class="btn btn-success w-100 fw-bold">✅ Aprobar y Publicar</button>
                                        <button type="submit" name="accion" value="rechazar" class="btn btn-outline-danger w-100 mt-2">❌ Rechazar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>