<?php
/**
 * Principal.php
 * Ubicación: /public/Principal.php
 */

require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

// --- GESTIÓN DE MENSAJES FLASH ---
$mensaje_toast = "";
if (isset($_SESSION['mensaje_exito'])) {
    $mensaje_toast = $_SESSION['mensaje_exito'];
    unset($_SESSION['mensaje_exito']);
}

// --- LECTURA DE FILTROS (GET) ---
$filtro_tipo   = isset($_GET['tipo'])   ? $_GET['tipo']   : '';
$filtro_buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// --- CONSTRUCCIÓN DINÁMICA DEL SQL ---
$condiciones = ["G.estado = 'Activo'"];
$params = ['mi_id' => $IDusuario];

// Filtro por tipo
if ($filtro_tipo === 'Estudio') {
    $condiciones[] = "GE.ID_grupo IS NOT NULL";
} elseif ($filtro_tipo === 'Investigacion') {
    $condiciones[] = "GI.ID_grupo IS NOT NULL";
} elseif ($filtro_tipo === 'Voluntariado') {
    $condiciones[] = "GV.ID_grupo IS NOT NULL";
}

// Filtro por búsqueda (nombre o descripción)
if ($filtro_buscar !== '') {
    $condiciones[] = "(G.nombreGrupo LIKE :buscar OR G.descripcion LIKE :buscar)";
    $params['buscar'] = '%' . $filtro_buscar . '%';
}

$sql = "SELECT 
          G.ID_grupo, G.nombreGrupo, G.descripcion, G.fecha, G.cupoMaximo,
          COALESCE(GE.Modalidad, GI.Modalidad, 'No aplica') AS modalidad_final,
          CASE
            WHEN GE.ID_grupo IS NOT NULL THEN 'Estudio'
            WHEN GI.ID_grupo IS NOT NULL THEN 'Investigación'
            WHEN GV.ID_grupo IS NOT NULL THEN 'Voluntariado'
            ELSE 'Otro'
          END AS tipoGrupo,
          (SELECT COUNT(*) FROM MiembrosGrupos WHERE ID_grupo = G.ID_grupo) AS cupo_actual,
          mg_propio.ID_usuario AS soy_miembro
        FROM Grupo G
        LEFT JOIN GrupoEstudio GE ON G.ID_grupo = GE.ID_grupo
        LEFT JOIN GrupoInvestigacion GI ON G.ID_grupo = GI.ID_grupo
        LEFT JOIN GrupoVoluntariado GV ON G.ID_grupo = GV.ID_grupo
        LEFT JOIN MiembrosGrupos mg_propio 
            ON G.ID_grupo = mg_propio.ID_grupo AND mg_propio.ID_usuario = :mi_id
        WHERE " . implode(' AND ', $condiciones) . "
        ORDER BY G.fecha DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect-U - Principal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- CSS Bonito -->
    <link rel="stylesheet" href="../assets/css/Bonito.css" />
    
    <!-- ESTILOS ADICIONALES -->
    <style>
        :root {
            --utp-purple: #6f2c91;
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
        .accordion-button:not(.collapsed) { 
            color: var(--utp-purple); 
            background-color: rgba(111, 44, 145, 0.05); 
        }
        /* enlaces del cuerpo del acordeón (para que no se vean desordenados) */
        .accordion-body a { 
            display: block; 
            padding: 8px 12px; 
            color: #555; 
            text-decoration: none; 
            border-radius: 6px; 
            margin-bottom: 4px; 
        }
        .accordion-body a:hover { 
            background-color: rgba(111, 44, 145, 0.1); 
            color: var(--utp-purple); 
        }

        /* Contenedor Principal */
        .main-content {
            flex-grow: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        /* Filtros */
        .filtros-grupos {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            align-items: flex-end;
        }
        .filtros-grupos input,
        .filtros-grupos select {
            width: 220px;
        }

        /* Grid de tarjetas */
        .ContenedorGrupos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            align-content: start;
            position: relative;
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

        /* Botones */
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
        .btn-disabled {
            display: block; 
            text-align: center; 
            background-color: #e9ecef; 
            color: #6c757d; 
            padding: 12px;
            border-radius: 8px; 
            font-weight: 600; 
            margin-top: 15px; 
            border: 1px solid #dee2e6; 
            cursor: default;
        }
        .text-danger { color: #dc3545 !important; }
    </style>
</head>
<body>

    <!-- MENÚ LATERAL -->
    <div class="menu">
        <div class="mb-4 text-center"><h4>🎓 CONNECT-U</h4></div>
        <div class="accordion" id="menuAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral">
                        🔎 General
                    </button>
                </h2>
                <div id="collapseGeneral" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <a href="Principal.php" style="color: #6f2c91; font-weight: bold;">🏠 Inicio</a>
                        <a href="mis_solicitudes.php">📨 Mis Solicitudes</a>
                        <a href="mis_grupos.php">👥 Mis Grupos</a>
                        <a href="notificaciones.php">🔔 Notificaciones</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCreador">
                        🛠 Como creador
                    </button>
                </h2>
                <div id="collapseCreador" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a href="CreacionGrupo.php">➕ Crear Grupo</a>
                        <a href="mis_grupos_creados.php">📂 Grupos que administro</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta">
                        ⚙️ Cuenta
                    </button>
                </h2>
                <div id="collapseCuenta" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <a href="perfil.php">👤 Perfil</a>
                        <a href="../src/procesos/logout.php" class="text-danger">🚪 Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">

        <!-- FORMULARIO DE FILTROS -->
        <form method="GET" class="filtros-grupos mb-3">
            <div>
                <label class="form-label mb-1">Tipo de grupo</label>
                <select name="tipo" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <option value="Estudio"       <?= $filtro_tipo === 'Estudio' ? 'selected' : '' ?>>Estudio</option>
                    <option value="Investigacion" <?= $filtro_tipo === 'Investigacion' ? 'selected' : '' ?>>Investigación</option>
                    <option value="Voluntariado"  <?= $filtro_tipo === 'Voluntariado' ? 'selected' : '' ?>>Voluntariado</option>
                </select>
            </div>

            <div>
                <label class="form-label mb-1">Buscar</label>
                <input type="text" name="buscar" class="form-control form-control-sm"
                       placeholder="Nombre o descripción..."
                       value="<?= htmlspecialchars($filtro_buscar) ?>">
            </div>

            <div>
                <button type="submit" class="btn btn-primary btn-sm mt-4">Aplicar filtros</button>
                <a href="Principal.php" class="btn btn-secondary btn-sm mt-4">Limpiar</a>
            </div>
        </form>

        <!-- GRID DE TARJETAS -->
        <div class="ContenedorGrupos">
            <?php if (empty($grupos)): ?>
                <p class="text-muted">No se encontraron grupos con los filtros aplicados.</p>
            <?php else: ?>
                <?php foreach ($grupos as $grupo): ?>
                    <div class="card">
                        <h3 class="card-title">
                            Grupo de <?= htmlspecialchars($grupo['tipoGrupo']) ?>: 
                            <?= htmlspecialchars($grupo['nombreGrupo']) ?>
                        </h3>
                        
                        <p><strong>Modalidad:</strong> <?= htmlspecialchars($grupo['modalidad_final']) ?></p>
                        <p><strong>Descripción:</strong> <?= htmlspecialchars($grupo['descripcion']) ?></p>
                        
                        <p class="fecha">
                            <strong>Fecha de creación:</strong>
                            <?php 
                                $fechaVencimiento = new DateTime($grupo['fecha']);
                                echo $fechaVencimiento->format('d \d\e F, Y'); 
                            ?>
                        </p>
                        
                        <p><strong>Cupo:</strong> <?= $grupo['cupo_actual'] ?> / <?= $grupo['cupoMaximo'] ?></p>
                        
                        <!-- BOTÓN -->
                        <?php if ($grupo['soy_miembro']): ?>
                            <div class="btn-disabled">✅ Ya eres miembro</div>
                        <?php elseif ($grupo['cupo_actual'] >= $grupo['cupoMaximo']): ?>
                            <div class="btn-disabled" style="background-color: #f8d7da; color: #721c24;">⛔ Grupo Lleno</div>
                        <?php else: ?>
                            <a href="solicitud_grupo.php?id_grupo=<?= $grupo['ID_grupo'] ?>" class="btn-card">Solicitar Unirse</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- TOAST FLOTANTE -->
    <?php if ($mensaje_toast): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= htmlspecialchars($mensaje_toast) ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Bootstrap JS (una sola vez, para acordeón + toast) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php if ($mensaje_toast): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastLiveExample = document.getElementById('liveToast');
            if (toastLiveExample) {
                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>
