<?php
/**
 * solicitud_grupo.php
 * Ubicación: /public/solicitud_grupo.php
 */

require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

$ID_grupo_url = $_GET['id_grupo'] ?? null;
$nombre_grupo = 'Grupo Desconocido';

if (!$ID_grupo_url) {
    header("Location: Principal.php");
    exit;
}

// Obtener nombre del grupo para mostrarlo
$sql = "SELECT nombreGrupo FROM Grupo WHERE ID_grupo = :id";
$stmt = $conexion->prepare($sql);
$stmt->execute(['id' => $ID_grupo_url]);
$grupo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($grupo) {
    $nombre_grupo = $grupo['nombreGrupo'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Unirse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/Bonito.css">
    <style>
        body {
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            border-top: 6px solid #6f2c91;
        }
        .btn-submit {
            background-color: #6f2c91;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-weight: 700;
            margin-top: 20px;
        }
        .btn-submit:hover { background-color: #5a2376; color: white; }
    </style>
</head>
<body>

<div class="form-container">
    <h3 class="text-center fw-bold mb-2" style="color: #333;">Unirse al Grupo</h3>
    <p class="text-center text-muted mb-4">Solicitud para: <strong><?= htmlspecialchars($nombre_grupo) ?></strong></p>
    
    <!-- 🛑 RUTA CORREGIDA AQUÍ (Apunta a src/procesos) 🛑 -->
    <form action="/ProyectoCoonectU/src/procesos/procesar_solicitud.php" method="POST">
        
        <input type="hidden" name="ID_grupo" value="<?= htmlspecialchars($ID_grupo_url) ?>">

        <div class="mb-3">
            <label for="mensaje" class="form-label fw-bold text-secondary">Mensaje al Administrador</label>
            <textarea id="mensaje" name="mensaje" class="form-control" rows="4" 
                      placeholder="Hola, me gustaría unirme porque..." required></textarea>
            <div class="form-text">Explica brevemente tu interés.</div>
        </div>

        <button type="submit" class="btn-submit">Enviar Solicitud</button>
        <a href="Principal.php" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">Cancelar</a>
    </form>
</div>

</body>
</html>