<?php
/**
 * mis_grupos_creados.php
 * Ubicación: /public/mis_grupos_creados.php
 */

require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

// 1. Obtener mis grupos y conteos
$sql = "
SELECT 
    g.ID_grupo, g.nombreGrupo, g.descripcion, g.cupoMaximo, g.fecha, g.estado,
    (SELECT COUNT(*) FROM solicitudgrupo s WHERE s.ID_grupo = g.ID_grupo AND s.estado = 'Pendiente') as solicitudes_pendientes,
    (SELECT COUNT(*) FROM miembrosgrupos m WHERE m.ID_grupo = g.ID_grupo) as miembros_actuales
FROM Grupo g
WHERE g.administradorGrupo = :id
ORDER BY g.fecha DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute(['id' => $IDusuario]);
$misGruposAdmin = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Grupos | Connect-U</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- CSS Base -->
    <link rel="stylesheet" href="../assets/css/Bonito.css">
    
    <style>
        /* --- ESTILOS DE SISTEMA UNIFICADO --- */
        body {
            background-color: #f0f0f0; 
            display: block !important;
        }

        /* BANNER MORADO (Igual que en Mis Grupos) */
        .header-banner {
            background-color: #6f2c91;
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            text-align: center;
            position: relative;
        }
        
        .header-title {
            font-weight: 800;
            font-size: 2.2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        /* BOTÓN VOLVER (Integrado) */
        .btn-back-banner {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            text-decoration: none;
            font-weight: 600;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 50px;
            transition: background 0.3s;
        }
        .btn-back-banner:hover { background: rgba(255,255,255,0.4); color: white; }

        .container-dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
        }

        /* TARJETAS DE ADMINISTRADOR */
        .card-admin { 
            background: white;
            border: none; 
            border-top: 6px solid #6f2c91; /* Borde superior Morado */
            border-radius: 16px;
            transition: all 0.3s; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-admin:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 30px rgba(111, 44, 145, 0.15); 
        }

        .card-body-custom {
            padding: 25px;
            flex-grow: 1;
        }

        /* Botón de Gestión */
        .btn-manage {
            margin: 0 20px 20px 20px;
            padding: 12px;
            background-color: white;
            border: 2px solid #6f2c91;
            color: #6f2c91;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.2s;
            text-align: center;
            display: block;
            width: auto;
        }
        .btn-manage:hover {
            background-color: #6f2c91;
            color: white;
        }

        /* BADGES */
        .badge-requests {
            background-color: #dc3545;
            color: white;
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 50px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }

        /* ESTILOS DEL MODAL (Ajustados al tema) */
        .modal-header-custom { background-color: #6f2c91; color: white; }
        
        /* Pestañas Moradas */
        .nav-tabs .nav-link { color: #666; font-weight: 600; border: none; }
        .nav-tabs .nav-link.active { 
            color: #6f2c91; 
            border-bottom: 3px solid #6f2c91; 
            background: transparent;
        }
        .nav-tabs { border-bottom: 1px solid #ddd; }

        /* Lista de Miembros */
        .member-item {
            background-color: #fff;
            border: 1px solid #eee;
            border-left: 4px solid #20c997; /* Verde para miembros */
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

    <!-- 1. BANNER SUPERIOR -->
    <div class="header-banner">
        <div class="container-fluid position-relative">
            <a href="Principal.php" class="btn-back-banner">⬅ Volver al Inicio</a>
            <h1 class="header-title">🛠️ Panel de Gestión</h1>
        </div>
    </div>

    <div class="container-dashboard">
        
        <!-- Mensajes Flash -->
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4">
                <?= htmlspecialchars($_SESSION['mensaje_exito']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>

        <!-- Botón Crear Nuevo (Flotante o Superior) -->
        <div class="d-flex justify-content-end mb-4">
            <a href="CreacionGrupo.php" class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow-sm">
                + Crear Nuevo Grupo
            </a>
        </div>

        <?php if (count($misGruposAdmin) === 0): ?>
            <div class="text-center p-5 bg-white rounded-4 shadow-sm">
                <div style="font-size: 4rem;">👨‍🏫</div>
                <h3 class="text-muted mt-3">No administras ningún grupo</h3>
                <p>Crea uno nuevo para empezar a ver opciones de gestión aquí.</p>
            </div>
        <?php else: ?>
            
            <div class="row g-4">
                <?php foreach ($misGruposAdmin as $g): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-admin">
                            
                            <div class="card-body-custom">
                                <!-- Cabecera Tarjeta -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark border">
                                        👥 <?= $g['miembros_actuales'] ?> / <?= $g['cupoMaximo'] ?>
                                    </span>
                                    <?php if ($g['solicitudes_pendientes'] > 0): ?>
                                        <span class="badge-requests">
                                            🔔 <?= $g['solicitudes_pendientes'] ?> Nuevas
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h4 class="fw-bold text-dark mb-2"><?= htmlspecialchars($g['nombreGrupo']) ?></h4>
                                <small class="text-uppercase fw-bold text-muted" style="font-size: 0.7rem;">
                                    Estado: <span class="<?= $g['estado'] === 'Activo' ? 'text-success' : 'text-warning' ?>"><?= strtoupper($g['estado']) ?></span>
                                </small>
                                
                                <p class="text-secondary mt-3 mb-0 small" style="line-height: 1.5;">
                                    <?= mb_substr($g['descripcion'], 0, 100) . '...' ?>
                                </p>
                            </div>
                            
                            <button class="btn-manage" data-bs-toggle="modal" data-bs-target="#modalGestion<?= $g['ID_grupo'] ?>">
                                ⚙️ Gestionar
                            </button>
                        </div>
                    </div>

                    <!-- MODAL DE GESTIÓN -->
                    <div class="modal fade" id="modalGestion<?= $g['ID_grupo'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title fw-bold">Gestionando: <?= htmlspecialchars($g['nombreGrupo']) ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    
                                    <!-- PESTAÑAS -->
                                    <ul class="nav nav-tabs mb-4" id="tabs<?= $g['ID_grupo'] ?>" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#solicitudes<?= $g['ID_grupo'] ?>">
                                                📩 Solicitudes <span class="badge bg-danger rounded-pill"><?= $g['solicitudes_pendientes'] ?></span>
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#miembros<?= $g['ID_grupo'] ?>">
                                                👥 Miembros
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#editar<?= $g['ID_grupo'] ?>">
                                                ✏️ Editar
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        
                                        <!-- PANEL SOLICITUDES -->
                                        <div class="tab-pane fade show active" id="solicitudes<?= $g['ID_grupo'] ?>">
                                            <?php
                                            $sqlSol = "SELECT s.ID_solicitud, s.mensaje, s.fecha, u.nombre, u.correo 
                                                       FROM solicitudgrupo s 
                                                       JOIN usuario u ON s.IDusuario = u.IDusuario 
                                                       WHERE s.ID_grupo = :idg AND s.estado = 'Pendiente'";
                                            $stmtSol = $conexion->prepare($sqlSol);
                                            $stmtSol->execute(['idg' => $g['ID_grupo']]);
                                            $solicitudes = $stmtSol->fetchAll();
                                            ?>

                                            <?php if (count($solicitudes) === 0): ?>
                                                <div class="text-center py-5 text-muted bg-light rounded">
                                                    <div class="h3">👍</div>
                                                    <p class="mb-0">No hay solicitudes pendientes.</p>
                                                </div>
                                            <?php else: ?>
                                                <div class="list-group">
                                                    <?php foreach ($solicitudes as $sol): ?>
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($sol['nombre']) ?></h6>
                                                                <small class="text-muted"><?= $sol['correo'] ?></small>
                                                                <div class="mt-1 small bg-light p-2 rounded fst-italic">"<?= htmlspecialchars($sol['mensaje']) ?>"</div>
                                                            </div>
                                                            <div class="d-flex gap-2">
                                                                <form action="../src/procesos/procesar_gestion_solicitud.php" method="POST">
                                                                    <input type="hidden" name="id_solicitud" value="<?= $sol['ID_solicitud'] ?>">
                                                                    <input type="hidden" name="accion" value="aceptar">
                                                                    <button type="submit" class="btn btn-sm btn-success fw-bold">Aceptar</button>
                                                                </form>
                                                                <form action="../src/procesos/procesar_gestion_solicitud.php" method="POST">
                                                                    <input type="hidden" name="id_solicitud" value="<?= $sol['ID_solicitud'] ?>">
                                                                    <input type="hidden" name="accion" value="rechazar">
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Rechazar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- PANEL MIEMBROS -->
                                        <div class="tab-pane fade" id="miembros<?= $g['ID_grupo'] ?>">
                                            <?php
                                            $sqlMem = "SELECT u.IDusuario, u.nombre, u.correo 
                                                       FROM miembrosgrupos m 
                                                       JOIN usuario u ON m.ID_usuario = u.IDusuario 
                                                       WHERE m.ID_grupo = :idg";
                                            $stmtMem = $conexion->prepare($sqlMem);
                                            $stmtMem->execute(['idg' => $g['ID_grupo']]);
                                            $miembros = $stmtMem->fetchAll();
                                            ?>

                                            <?php if (count($miembros) === 0): ?>
                                                <div class="text-center py-5 text-muted bg-light rounded">
                                                    <p class="mb-0">Aún no hay miembros.</p>
                                                </div>
                                            <?php else: ?>
                                                <div class="d-flex flex-column gap-2">
                                                    <?php foreach ($miembros as $mem): ?>
                                                        <div class="member-item">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center fw-bold text-primary border" style="width: 40px; height: 40px;">
                                                                    <?= strtoupper(substr($mem['nombre'], 0, 1)) ?>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($mem['nombre']) ?></div>
                                                                    <div class="small text-muted"><?= htmlspecialchars($mem['correo']) ?></div>
                                                                </div>
                                                            </div>
                                                            <form action="../src/procesos/procesar_eliminar_miembro.php" method="POST" onsubmit="return confirm('¿Expulsar usuario?');">
                                                                <input type="hidden" name="id_grupo" value="<?= $g['ID_grupo'] ?>">
                                                                <input type="hidden" name="id_usuario" value="<?= $mem['IDusuario'] ?>">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">Expulsar</button>
                                                            </form>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- PANEL EDITAR -->
                                        <div class="tab-pane fade" id="editar<?= $g['ID_grupo'] ?>">
                                            <form action="../src/procesos/procesar_editar_grupo.php" method="POST">
                                                <input type="hidden" name="id_grupo" value="<?= $g['ID_grupo'] ?>">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nombre del Grupo</label>
                                                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($g['nombreGrupo']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Descripción</label>
                                                    <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($g['descripcion']) ?></textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Cupo Máximo</label>
                                                    <input type="number" name="cupo" class="form-control" value="<?= $g['cupoMaximo'] ?>" min="1" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: #6f2c91; border:none;">
                                                    Guardar Cambios
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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