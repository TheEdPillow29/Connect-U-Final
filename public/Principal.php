<?php
/**
 * Principal.php
 * Ubicación: /public/Principal.php
 */

// --- 1. LÓGICA DE SERVIDOR ---
require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

// --- 2. CONSULTA DE DATOS CORREGIDA ---
$sql = "SELECT 
          G.ID_grupo,
          G.nombreGrupo,
          G.descripcion,
          G.fecha,
          G.cupoMaximo,
          -- ESTA ES LA LÍNEA QUE FALTABA PARA QUE SALGA LA MODALIDAD:
          COALESCE(GE.Modalidad, GI.Modalidad, 'No aplica') AS modalidad_final,
          CASE
            WHEN GE.ID_grupo IS NOT NULL THEN 'Estudio'
            WHEN GI.ID_grupo IS NOT NULL THEN 'Investigación'
            WHEN GV.ID_grupo IS NOT NULL THEN 'Voluntariado'
            ELSE 'Otro'
          END AS tipoGrupo,
          (SELECT COUNT(*) FROM MiembrosGrupos WHERE ID_grupo = G.ID_grupo) AS cupo_actual
        FROM Grupo G
        LEFT JOIN GrupoEstudio GE ON G.ID_grupo = GE.ID_grupo
        LEFT JOIN GrupoInvestigacion GI ON G.ID_grupo = GI.ID_grupo
        LEFT JOIN GrupoVoluntariado GV ON G.ID_grupo = GV.ID_grupo
        ORDER BY G.fecha DESC";

$consulta = $conexion->query($sql);
$grupos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect-U - Principal</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ESTILOS CSS (Incrustados para garantizar diseño) -->
    <style>
        :root {
            --utp-purple: #6f2c91;
            --utp-gold:   #fdb827;
            --text-dark:  #333333;
            --bg-light:   #f5f5f7;
        }

        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
        }

        /* Menú Lateral */
        .menu {
            width: 260px;
            padding: 20px;
            background-color: #ffffff;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .menu h4 {
            margin-top: 15px;
            margin-bottom: 30px;
            font-weight: 800;
            color: var(--utp-purple);
            text-align: center;
        }

        .accordion-button {
            color: #444;
            font-weight: 600;
            box-shadow: none !important;
        }
        .accordion-button:not(.collapsed) {
            color: var(--utp-purple);
            background-color: rgba(111, 44, 145, 0.05);
        }
        .accordion-body a {
            display: block;
            padding: 8px 12px;
            color: #555;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        .accordion-body a:hover {
            background-color: rgba(111, 44, 145, 0.1);
            color: var(--utp-purple);
            font-weight: 500;
        }

        /* Contenedor Principal */
        .ContenedorGrupos {
            flex-grow: 1;
            padding: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            align-content: start;
        }

        /* Tarjetas */
        .card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .card h3 {
            font-size: 1.25rem;
            color: var(--utp-purple);
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .card p {
            margin-bottom: 10px;
            color: #555;
            line-height: 1.5;
        }
        
        .card .fecha {
            font-size: 0.9rem;
            color: #888;
            margin-top: auto;
            font-style: italic;
        }

        .btn-card {
            display: block;
            text-align: center;
            background-color: var(--utp-purple);
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 15px;
            border: none;
            transition: background 0.3s;
        }

        .btn-card:hover {
            background-color: #5a2376;
            color: white;
        }
        
        .text-danger {
            color: #dc3545 !important;
        }
    </style>
</head>
<body>

    <!-- MENÚ LATERAL -->
    <div class="menu">
        <div class="mb-4 text-center">
            <h4>🎓 CONNECT-U</h4>
        </div>

        <div class="accordion" id="menuAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGeneral">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral">🔎 General</button>
                </h2>
                <div id="collapseGeneral" class="accordion-collapse collapse show" data-bs-parent="#menuAccordion">
                    <div class="accordion-body">
                        <a href="Principal.php">🏠 Inicio</a>
                        <a href="mis_solicitudes.php">📨 Mis Solicitudes</a>
                        <a href="mis_grupos.php">👥 Mis Grupos</a>
                        <a href="notificaciones.php">🔔 Notificaciones</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCreador">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreador">🛠 Como creador</button>
                </h2>
                <div id="collapseCreador" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                    <div class="accordion-body">
                        <a href="CreacionGrupo.php">➕ Crear Grupo</a>
                        <a href="mis_grupos_creados.php">📂 Grupos que administro</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCuenta">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta">⚙️ Cuenta</button>
                </h2>
                <div id="collapseCuenta" class="accordion-collapse collapse" data-bs-parent="#menuAccordion">
                    <div class="accordion-body">
                        <a href="perfil.php">👤 Perfil</a>
                        <a href="../src/procesos/logout.php" class="text-danger">🚪 Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="ContenedorGrupos">
        
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                <?= htmlspecialchars($_SESSION['mensaje_exito']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>

        <?php foreach ($grupos as $grupo): ?>
            <div class="card">
                <h3 class="card-title">Grupo de <?= htmlspecialchars($grupo['tipoGrupo']) ?>: <?= htmlspecialchars($grupo['nombreGrupo']) ?></h3>
                
                <!-- AHORA SÍ SE MOSTRARÁ LA MODALIDAD SIN ERRORES -->
                <p><strong>Modalidad:</strong> <?= htmlspecialchars($grupo['modalidad_final']) ?></p>
                
                <p><strong>Descripción:</strong> <?= htmlspecialchars($grupo['descripcion']) ?></p>
                
                <p class="fecha"><strong>Fecha de creación:</strong> 
                    <?php 
                        $fechaVencimiento = new DateTime($grupo['fecha']);
                        echo $fechaVencimiento->format('d \d\e F, Y'); 
                    ?>
                </p>
                
                <p><strong>Cupo:</strong> <?= $grupo['cupo_actual'] ?> / <?= $grupo['cupoMaximo'] ?></p>
                
                <a href="solicitud_grupo.php?id_grupo=<?= $grupo['ID_grupo'] ?>" class="btn-card">
                    Solicitar Unirse
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>