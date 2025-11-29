<?php
session_start();

try {
    $conexion = new PDO('mysql:host=127.0.0.1;port=3307;dbname=sistemagruposv2', 'AdministradorWeb', 'h9!(pZ.P2GYYbFe/');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$IDusuario = $_SESSION['IDusuario'] ?? null;
if (!$IDusuario) {
    header('Location: login.php');
    exit;
}

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
    <title>Mis Solicitudes</title>
    <link rel="stylesheet" href="/assets/css/Bonito.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Colores personalizados para estados */
        .estado-pendiente {
            color: #f39c12;
            font-weight: bold;
        }
        .estado-aprobado {
            color: #27ae60;
            font-weight: bold;
        }
        .estado-rechazado {
            color: #c0392b;
            font-weight: bold;
        }

        /* Encabezado personalizado */
        .Contenedor {
            background-color: var(--utp-purple);
            padding: 1.5rem;
            text-align: center;
        }

        .Contenedor p {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }

        /* Tabla personalizada */
        .tabla-solicitudes {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .tabla-solicitudes th {
            background-color: var(--utp-purple);
            color: white;
            text-align: center;
        }

        .tabla-solicitudes td {
            color: var(--text-dark);
            vertical-align: middle;
        }

        /* Botón personalizado reutilizando btn-card */
        .btn-volver {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">

<div class="Contenedor">
    <p>📨 Mis Solicitudes</p>
</div>

<div class="container mt-4 mb-5">
    <?php if (count($solicitudes) > 0): ?>
        <div class="table-responsive tabla-solicitudes">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Grupo</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudes as $i => $solicitud): ?>
                        <tr>
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($solicitud['nombreGrupo']) ?></td>
                            <td><?= htmlspecialchars($solicitud['mensaje']) ?></td>
                            <td class="text-center"><?= (new DateTime($solicitud['fecha']))->format('d/m/Y') ?></td>
                            <td class="text-center">
                                <span class="<?php
                                    switch (strtolower($solicitud['estado'])) {
                                        case 'aprobado': echo 'estado-aprobado'; break;
                                        case 'rechazado': echo 'estado-rechazado'; break;
                                        default: echo 'estado-pendiente';
                                    }
                                ?>">
                                    <?= ucfirst($solicitud['estado']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            No has realizado ninguna solicitud aún.
        </div>
    <?php endif; ?>

    <!-- Botón de regreso -->
    <div class="text-center">
        <a href="Principal.php" class="btn-card btn-volver">⬅️ Volver al inicio</a>
    </div>
</div>

</body>
</html>
