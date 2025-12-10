<?php
/**
 * mis_solicitudes.php
 * Ubicación: /public/mis_solicitudes.php
 */

// --- 1. LÓGICA DE SERVIDOR (Backend Centralizado) ---
require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

// --- 2. CONSULTA DE DATOS ---
$sql = "SELECT 
            SG.ID_solicitud,
            G.nombreGrupo,
            SG.mensaje,
            SG.fecha,
            SG.estado
        FROM SolicitudGrupo SG
        INNER JOIN Grupo G ON SG.ID_grupo = G.ID_grupo
        WHERE SG.IDusuario = :idusuario
        ORDER BY SG.fecha DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute(['idusuario' => $IDusuario]);
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes</title>
    
    <!-- 1. Tu Diseño Personalizado (Ruta Corregida) -->
    <link rel="stylesheet" href="../assets/css/Bonito.css">
    
    <!-- 2. Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        /* Ajustes específicos para esta página */
        body {
            background-color: var(--bg-light, #f5f5f7);
        }

        /* Encabezado */
        .Contenedor {
            background-color: var(--utp-purple, #6f2c91);
            padding: 2rem;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .Contenedor p {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            color: white;
            letter-spacing: 1px;
        }

        /* Tabla flotante */
        .tabla-contenedor {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--utp-purple, #6f2c91);
            color: white;
            text-align: center;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            color: #444;
            border-bottom: 1px solid #eee;
        }

        .table tbody tr:hover {
            background-color: #f9f9f9;
        }

        /* Botón Volver */
        .btn-volver {
            background-color: #6c757d;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            margin-top: 30px;
            border: 2px solid #6c757d;
        }

        .btn-volver:hover {
            background-color: white;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="Contenedor">
    <p>📨 Mis Solicitudes Enviadas</p>
</div>

<div class="container mb-5">
    <?php if (count($solicitudes) > 0): ?>
        <div class="tabla-contenedor table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Grupo</th>
                        <th>Mensaje Enviado</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $i => $solicitud): ?>
                        <tr>
                            <td class="text-center fw-bold text-secondary"><?= $i + 1 ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($solicitud['nombreGrupo']) ?></td>
                            <td><small class="text-muted"><?= htmlspecialchars($solicitud['mensaje']) ?></small></td>
                            <td class="text-center"><?= (new DateTime($solicitud['fecha']))->format('d/m/Y') ?></td>
                            <td class="text-center">
                                <?php 
                                    // Lógica para mostrar Badges (Etiquetas) en lugar de texto plano
                                    $estado = ucfirst(strtolower($solicitud['estado']));
                                    $badgeClass = 'bg-secondary'; // Por defecto
                                    
                                    if ($estado === 'Aprobado') $badgeClass = 'bg-success';
                                    elseif ($estado === 'Rechazado') $badgeClass = 'bg-danger';
                                    elseif ($estado === 'Pendiente') $badgeClass = 'bg-warning text-dark';
                                ?>
                                <span class="badge rounded-pill <?= $badgeClass ?> px-3 py-2">
                                    <?= $estado ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4 p-4 shadow-sm" style="border-radius: 10px;">
            <h4>📭 Aún no has enviado ninguna solicitud.</h4>
            <p>Ve a la página principal para buscar grupos de tu interés.</p>
        </div>
    <?php endif; ?>

    <!-- Botón de regreso -->
    <div class="text-center">
        <a href="Principal.php" class="btn-volver">⬅️ Volver al Inicio</a>
    </div>
</div>

</body>
</html>