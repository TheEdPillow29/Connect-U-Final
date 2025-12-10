<?php
/**
 * perfil.php
 * Ubicación: /public/perfil.php
 */

require_once '../src/libs/verificar_sesion.php';
require_once '../src/db/config_db.php';

// ---------------------------------------------------------------------
// 1. CARGAR DATOS DEL USUARIO LOGUEADO
// ---------------------------------------------------------------------

// Se asume que $IDusuario viene de verificar_sesion.php
// Ej: $_SESSION['IDusuario'] o similar
// Aquí solo lo usamos directamente.
$mensaje_exito = "";
$mensaje_error = "";

// Si se envió el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'actualizar_perfil') {
    $nombre      = trim($_POST['nombre'] ?? '');
    $correo      = trim($_POST['correo'] ?? '');
    $Numtelefono = trim($_POST['Numtelefono'] ?? '');

    if ($nombre === '' || $correo === '') {
        $mensaje_error = "El nombre y el correo son obligatorios.";
    } else {
        try {
            $sqlUpdate = "
                UPDATE usuario
                SET nombre = :nombre,
                    correo = :correo,
                    Numtelefono = :Numtelefono
                WHERE IDusuario = :IDusuario
            ";
            $stmtUpd = $conexion->prepare($sqlUpdate);
            $stmtUpd->execute([
                'nombre'      => $nombre,
                'correo'      => $correo,
                'Numtelefono' => $Numtelefono,
                'IDusuario'   => $IDusuario
            ]);
            $mensaje_exito = "Tu perfil se actualizó correctamente.";
        } catch (Exception $e) {
            $mensaje_error = "Ocurrió un error al actualizar el perfil.";
        }
    }
}

// Consultar datos del usuario
$sqlUser = "
    SELECT IDusuario, correo, nombre, Numtelefono
    FROM usuario
    WHERE IDusuario = :IDusuario
";
$stmtUser = $conexion->prepare($sqlUser);
$stmtUser->execute(['IDusuario' => $IDusuario]);
$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Si por algún motivo no se encuentra, evitamos errores
if (!$usuario) {
    $usuario = [
        'IDusuario'  => $IDusuario,
        'correo'     => '',
        'nombre'     => 'Usuario',
        'Numtelefono'=> ''
    ];
}

// ---------------------------------------------------------------------
// 2. ESTADÍSTICAS DEL USUARIO (grupos, solicitudes, etc.)
// ---------------------------------------------------------------------

// Grupos donde es administrador
$sqlAdmin = "
    SELECT COUNT(*) AS total
    FROM grupo
    WHERE administradorGrupo = :IDusuario
";
$stmtAdmin = $conexion->prepare($sqlAdmin);
$stmtAdmin->execute(['IDusuario' => $IDusuario]);
$totalAdmin = (int)$stmtAdmin->fetchColumn();

// Grupos donde es miembro (no administrador)
$sqlMember = "
    SELECT COUNT(DISTINCT g.ID_grupo) AS total
    FROM grupo g
    INNER JOIN miembrosgrupos mg ON g.ID_grupo = mg.ID_grupo
    WHERE mg.ID_usuario = :IDusuario
      AND g.administradorGrupo <> :IDusuario
";
$stmtMember = $conexion->prepare($sqlMember);
$stmtMember->execute(['IDusuario' => $IDusuario]);
$totalMiembro = (int)$stmtMember->fetchColumn();

// Solicitudes pendientes enviadas por el usuario
$sqlSol = "
    SELECT COUNT(*) AS total
    FROM solicitudgrupo
    WHERE IDusuario = :IDusuario
      AND estado = 'Pendiente'
";
$stmtSol = $conexion->prepare($sqlSol);
$stmtSol->execute(['IDusuario' => $IDusuario]);
$totalSolicitudesPend = (int)$stmtSol->fetchColumn();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Connect-U</title>

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
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
        }

        /* TARJETA PRINCIPAL DE PERFIL */
        .profile-card {
            background-color: white;
            border-radius: 18px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            padding: 25px 30px;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6f2c91, #b46ad6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.3rem;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .chip-id {
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 999px;
            background-color: #f4ecfb;
            color: #6f2c91;
            font-weight: 600;
            border: 1px solid rgba(111,44,145,0.15);
        }

        .label-small {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #6c757d;
        }

        .value-text {
            font-size: 0.95rem;
            font-weight: 600;
            color: #343a40;
        }

        .btn-edit {
            border-radius: 999px;
            font-weight: 600;
        }

        /* TARJETAS DE ESTADÍSTICAS */
        .stat-card {
            background-color: white;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.06);
        }
        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #6f2c91;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 600;
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
            <span class="icon-header">🙋‍♂️</span> Mi Perfil
        </h1>
    </div>

    <div class="container-dashboard">

        <?php if ($mensaje_exito): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje_exito) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($mensaje_error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensaje_error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <!-- TARJETA PERFIL -->
            <div class="col-lg-7">
                <div class="profile-card">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-circle me-3">
                            <?= strtoupper(substr($usuario['nombre'], 0, 1)) ?>
                        </div>
                        <div>
                            <h3 class="mb-1"><?= htmlspecialchars($usuario['nombre']) ?></h3>
                            <div class="chip-id mb-1">
                                ID: <?= htmlspecialchars($usuario['IDusuario']) ?>
                            </div>
                            <small class="text-muted">Este es tu perfil dentro del sistema Connect-U.</small>
                        </div>
                    </div>

                    <!-- Datos de contacto -->
                    <form method="post" class="mt-3">
                        <input type="hidden" name="accion" value="actualizar_perfil">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="label-small mb-1">Nombre completo</label>
                                <input type="text" name="nombre" class="form-control" 
                                       value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="label-small mb-1">Correo electrónico</label>
                                <input type="email" name="correo" class="form-control"
                                       value="<?= htmlspecialchars($usuario['correo']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="label-small mb-1">Teléfono</label>
                                <input type="text" name="Numtelefono" class="form-control"
                                       value="<?= htmlspecialchars($usuario['Numtelefono']) ?>" placeholder="Ej. 6000-0000">
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Estos datos se usan para que otros usuarios puedan contactarte en los grupos.
                            </small>
                            <button type="submit" class="btn btn-primary btn-edit">
                                💾 Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TARJETAS DE ESTADÍSTICAS / RESUMEN -->
            <div class="col-lg-5">
                <div class="stat-card mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?= $totalAdmin ?></div>
                            <div class="stat-label">Grupos que administras</div>
                        </div>
                        <div style="font-size: 2rem;">👑</div>
                    </div>
                    <small class="text-muted">
                        Son los grupos donde apareces como administrador del grupo.
                    </small>
                </div>

                <div class="stat-card mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?= $totalMiembro ?></div>
                            <div class="stat-label">Grupos en los que eres miembro</div>
                        </div>
                        <div style="font-size: 2rem;">👥</div>
                    </div>
                    <small class="text-muted">
                        Incluye grupos de estudio, investigación y voluntariado donde fuiste aceptado.
                    </small>
                </div>

                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?= $totalSolicitudesPend ?></div>
                            <div class="stat-label">Solicitudes pendientes</div>
                        </div>
                        <div style="font-size: 2rem;">📩</div>
                    </div>
                    <small class="text-muted">
                        Son solicitudes que hiciste para unirte a grupos y aún no han sido respondidas.
                    </small>
                    <div class="mt-3">
                        <a href="mis_solicitudes.php" class="btn btn-outline-primary btn-sm">
                            Ver mis solicitudes
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Botón Volver Flotante -->
    <a href="Principal.php" class="btn-back-floating">⬅ Volver al Inicio</a>

</body>
</html>
