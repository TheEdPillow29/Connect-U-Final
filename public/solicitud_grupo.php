<?php
// Inicia la sesión para poder usar las variables de sesión más adelante.
session_start();

// 1. Captura el ID del grupo desde la URL.
// Si no se proporciona un ID, muestra un error.
$id_grupo = $_GET['id_grupo'] ?? null;
if (!$id_grupo) {
    die("Error: No se ha especificado un grupo.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Formulario de Solicitud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #6f42c1, #a774ff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(111, 66, 193, 0.3);
            width: 100%;
            max-width: 480px;
        }
        h2 {
            margin-bottom: 30px;
            font-weight: 700;
            color: #4a4a4a;
            text-align: center;
        }
        textarea {
            border: 1.8px solid #d1c4e9;
            border-radius: 8px;
            padding: 12px 15px;
            resize: vertical;
            min-height: 120px;
        }
        textarea:focus {
            border-color: #6f42c1;
            outline: none;
            box-shadow: 0 0 8px rgba(111, 66, 193, 0.3);
        }
        .btn-submit {
            margin-top: 20px;
            background-color: #6f42c1;
            border: none;
            width: 100%;
            padding: 14px;
            font-weight: 700;
            color: white;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #5a379c;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Enviar Solicitud</h2>
    
    <form action="/src/procesos/procesar_solicitud.php" method="POST">

        <input type="hidden" name="ID_grupo" value="<?= htmlspecialchars($id_grupo) ?>">
        
        <div class="mb-4">
            <label for="mensaje" class="form-label">Mensaje para la solicitud</label>
            <textarea id="mensaje" name="mensaje" class="form-control" placeholder="Escribe aquí por qué quieres unirte..." required></textarea>
        </div>

        <button type="submit" class="btn-submit">Enviar Solicitud</button>
    </form>
</div>

</body>
</html>