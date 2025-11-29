<?php
session_start();
// Aquí asumes que tienes un sistema de login y guardas el IDusuario en sesión, por ejemplo:
$IDusuario = $_SESSION['IDusuario'] ?? null;

if (!$IDusuario) {
    // Si no está logueado, redirige o muestra error
    header("Location: login.php");
    exit;
}

if (!isset($_GET['ID_grupo'])) {
    echo "No se especificó el grupo.";
    exit;
}

$ID_grupo = $_GET['ID_grupo'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Formulario de Solicitud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2>Enviar solicitud para unirse al grupo</h2>
    <form action="/src/procesos/procesar_solicitud.php" method="POST">
        <input type="hidden" name="ID_grupo" value="<?= htmlspecialchars($ID_grupo) ?>" />
        <label for="mensaje" class="form-label">Mensaje para la solicitud:</label>
        <textarea name="mensaje" id="mensaje" class="form-control" rows="4" required></textarea>
        <br>
        <button type="submit" class="btn btn-success">Enviar solicitud</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
