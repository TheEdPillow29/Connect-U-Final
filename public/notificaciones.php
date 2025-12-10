<?php
/**
 * notificaciones.php
 * Ubicación: /public/notificaciones.php
 */

require_once '../src/libs/verificar_sesion.php';
require_once '../src/db/config_db.php';

// ---------------------------------------------------------------------
// 1. NOTIFICACIONES RECIBIDAS (cuando YO soy administrador)
// ---------------------------------------------------------------------

$sqlRecibidas = "
    SELECT 
        s.ID_solicitud,
        s.fecha,
        s.estado,
        s.mensaje,
        g.ID_grupo,
        g.nombreGrupo,
        u.nombre AS NombreSolicitante,
        u.correo AS CorreoSolicitante,
        u.Numtelefono AS TelefonoSolicitante
    FROM solicitudgrupo s
    INNER JOIN grupo g ON s.ID_grupo = g.ID_grupo
    INNER JOIN usuario u ON s.IDusuario = u.IDusuario
    WHERE g.administradorGrupo = :IDusuario
    ORDER BY s.fecha DESC
";
$stmtRec = $conexion->prepare($sqlRecibidas);
$stmtRec->execute(['IDusuario' => $IDusuario]);
$notificacionesRecibidas = $stmtRec->fetchAll(PDO::FETCH_ASSOC);

// ---------------------------------------------------------------------
// 2. NOTIFICACIONES ENVIADAS (solicitudes que YO hice a grupos)
// ---------------------------------------------------------------------

$sqlEnviadas = "
    SELECT 
        s.ID_solicitud,
        s.fecha,
        s.estado,
        s.mensaje,
        g.ID_grupo,
        g.nombreGrupo
    FROM solicitudgrupo s
    INNER JOIN grupo g ON s.ID_grupo = g.ID_grupo
    WHERE s.IDusuario = :IDusuario
    ORDER BY s.fecha DESC
";
$stmtEnv = $conexion->prepare($sqlEnviadas);
$stmtEnv->execute(['IDusuario' => $IDusuario]);
$notificacionesEnviadas = $stmtEnv->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones | Connect-U</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS Base -->
    <link rel="stylesheet" href="../assets/css/Bonito.css">

    <style>
        body {
            background-color: #f0f0f0;
            display: block !important;
        }

        /* BANNER SUPERIOR */
        .header-banner {
            background-color: #6f2c91;
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        .header-title {
            font-weight: 800;
            font-size: 2.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .icon-header { font-size: 1.8rem; }

        .container-dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6c757d;
            margin-bottom: 10px;
        }

        /* TARJETAS DE NOTIFICACIÓN */
        .notif-card {
            background-color: white;
            border-radius: 15px;
            padding: 18px 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .notif-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-title {
            font-weight: 700;
            color: #343a40;
            margin: 0;
        }

        .notif-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .badge-estado {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .badge-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-aprobado {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-rechazado {
            background-color: #f8d7da;
            color: #721c24;
        }

        .notif-date {
            font-size: 0.8rem;
            color: #999;
        }

        .notif-message {
            font-size: 0.9rem;
            color: #495057;
        }

        .notif-footer {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* BOTÓN VOLVER FLOTANTE */
        .btn-back-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #212529;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: transform 0.2s;
            z-index: 100;
        }
        .btn-back-floating:hover {
            background-color: black;
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <!-- BANNER SUPERIOR -->
    <div class="header-banner">
        <h1 class="header-title">
            <span class="icon-header">🔔</span> Notificaciones
        </h1>
    </div>

    <div class="container-dashboard">

        <div class="row g-4">

            <!-- COLUMNA IZQUIERDA: SOLICITUDES QUE LLEGAN A MIS GRUPOS -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="section-title">Solicitudes a mis grupos</div>
                    <span class="badge rounded-pill bg-dark">
                        <?= count($notificacionesRecibidas) ?> notificaciones
                    </span>
                </div>

                <?php if (count($notificacionesRecibidas) === 0): ?>
                    <div class="notif-card">
                        <div class="notif-header">
                            <p class="notif-title mb-0">No tienes solicitudes nuevas</p>
                        </div>
                        <p class="notif-message mb-1">
                            Cuando otros usuarios soliciten unirse a tus grupos, aparecerán aquí.
                        </p>
                    </div>
                <?php else: ?>
                    <div class="vstack gap-3">
                        <?php foreach ($notificacionesRecibidas as $n): ?>
                            <?php
                                // Badge según estado
                                $estado = $n['estado'];
                                $badgeClass = 'badge-pendiente';
                                $estadoTexto = $estado;
                                if ($estado === 'Aprobado') {
                                    $badgeClass = 'badge-aprobado';
                                } elseif ($estado === 'Rechazado') {
                                    $badgeClass = 'badge-rechazado';
                                }
                                $fechaObj = new DateTime($n['fecha']);
                            ?>
                            <div class="notif-card">
                                <div class="notif-header">
                                    <div>
                                        <p class="notif-title mb-0">
                                            Solicitud para <strong><?= htmlspecialchars($n['nombreGrupo']) ?></strong>
                                        </p>
                                        <div class="notif-subtitle">
                                            De: <?= htmlspecialchars($n['NombreSolicitante']) ?>
                                            (<?= htmlspecialchars($n['CorreoSolicitante']) ?>)
                                        </div>
                                    </div>
                                    <span class="badge-estado <?= $badgeClass ?>">
                                        <?= strtoupper($estadoTexto) ?>
                                    </span>
                                </div>

                                <div class="notif-date mb-1">
                                    📅 <?= $fechaObj->format('d/m/Y') ?> · ID solicitud: <?= htmlspecialchars($n['ID_solicitud']) ?>
                                </div>

                                <?php if (!empty($n['mensaje'])): ?>
                                    <p class="notif-message mb-2">
                                        “<?= nl2br(htmlspecialchars($n['mensaje'])) ?>”
                                    </p>
                                <?php endif; ?>

                                <div class="notif-footer d-flex justify-content-between align-items-center">
                                    <div>
                                        <?php if (!empty($n['TelefonoSolicitante'])): ?>
                                            📱 <?= htmlspecialchars($n['TelefonoSolicitante']) ?>
                                        <?php else: ?>
                                            📱 Teléfono no registrado
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <!-- Aquí en el futuro podrías poner enlaces para aprobar/rechazar -->
                                        <a href="detalle_grupo.php?id=<?= urlencode($n['ID_grupo']) ?>" class="btn btn-sm btn-outline-primary">
                                            Ver grupo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- COLUMNA DERECHA: MIS SOLICITUDES ENVIADAS -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="section-title">Mis solicitudes a grupos</div>
                    <span class="badge rounded-pill bg-dark">
                        <?= count($notificacionesEnviadas) ?> registros
                    </span>
                </div>

                <?php if (count($notificacionesEnviadas) === 0): ?>
                    <div class="notif-card">
                        <div class="notif-header">
                            <p class="notif-title mb-0">Aún no has enviado solicitudes</p>
                        </div>
                        <p class="notif-message mb-1">
                            Cuando solicites unirte a un grupo, podrás ver el estado aquí.
                        </p>
                        <div class="notif-footer">
                            👉 Explora grupos desde la página principal.
                        </div>
                    </div>
                <?php else: ?>
                    <div class="vstack gap-3">
                        <?php foreach ($notificacionesEnviadas as $n): ?>
                            <?php
                                $estado = $n['estado'];
                                $badgeClass = 'badge-pendiente';
                                $estadoTexto = $estado;
                                if ($estado === 'Aprobado') {
                                    $badgeClass = 'badge-aprobado';
                                } elseif ($estado === 'Rechazado') {
                                    $badgeClass = 'badge-rechazado';
                                }
                                $fechaObj = new DateTime($n['fecha']);
                            ?>
                            <div class="notif-card">
                                <div class="notif-header">
                                    <div>
                                        <p class="notif-title mb-0">
                                            Solicitud a <strong><?= htmlspecialchars($n['nombreGrupo']) ?></strong>
                                        </p>
                                        <div class="notif-subtitle">
                                            Estado de tu solicitud
                                        </div>
                                    </div>
                                    <span class="badge-estado <?= $badgeClass ?>">
                                        <?= strtoupper($estadoTexto) ?>
                                    </span>
                                </div>

                                <div class="notif-date mb-1">
                                    📅 <?= $fechaObj->format('d/m/Y') ?> · ID: <?= htmlspecialchars($n['ID_solicitud']) ?>
                                </div>

                                <?php if (!empty($n['mensaje'])): ?>
                                    <p class="notif-message mb-2">
                                        Tu mensaje: “<?= nl2br(htmlspecialchars($n['mensaje'])) ?>”
                                    </p>
                                <?php endif; ?>

                                <div class="notif-footer d-flex justify-content-between align-items-center">
                                    <span>Grupo: <?= htmlspecialchars($n['nombreGrupo']) ?></span>
                                    <a href="detalle_grupo.php?id=<?= urlencode($n['ID_grupo']) ?>" class="btn btn-sm btn-outline-secondary">
                                        Ver grupo
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>

    <!-- Botón Volver Flotante -->
    <a href="Principal.php" class="btn-back-floating">⬅ Volver al Inicio</a>

</body>
</html>
