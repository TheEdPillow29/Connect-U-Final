<?php
session_start();
// Redirige al login si el usuario no ha iniciado sesión.
if (!isset($_SESSION['IDusuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Crear Nuevo Grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background: linear-gradient(135deg, #4a148c, #7e57c2); min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px; font-family: 'Segoe UI', sans-serif; }
        .form-container { background-color: #fff; padding: 40px 35px; border-radius: 15px; box-shadow: 0 10px 30px rgba(74, 20, 140, 0.3); width: 100%; max-width: 580px; }
        h2 { margin-bottom: 30px; font-weight: 700; color: #3b0970; text-align: center; }
        .specific-fields { display: none; } /* Oculta los campos específicos por defecto */
        .btn-submit { margin-top: 25px; background-color: #4a148c; border: none; width: 100%; padding: 14px; font-weight: 700; color: white; border-radius: 10px; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Crear Nuevo Grupo</h2>
    <form action="/src/procesos/procesar_crear_grupo.php" method="POST">
        
        <div class="mb-3">
            <label for="nombreGrupo" class="form-label">Nombre del Grupo</label>
            <input type="text" id="nombreGrupo" name="nombreGrupo" class="form-control" required />
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="cupoMaximo" class="form-label">Cupo Máximo</label>
            <input type="number" id="cupoMaximo" name="cupoMaximo" class="form-control" min="1" required />
        </div>

        <div class="mb-3">
            <label for="tipoGrupo" class="form-label">Tipo de Grupo</label>
            <select id="tipoGrupo" name="tipoGrupo" class="form-select" required>
                <option value="" selected>Selecciona un tipo...</option>
                <option value="Estudio">Estudio</option>
                <option value="Investigacion">Investigación</option>
                <option value="Voluntariado">Voluntariado</option>
            </select>
        </div>

        <div id="camposEstudio" class="specific-fields">
            <div class="mb-3"><label for="materia" class="form-label">Materia</label><input type="text" name="materia" class="form-control"></div>
            <div class="mb-3"><label for="turno" class="form-label">Turno</label><select name="turno" class="form-select"><option value="Matutino">Matutino</option><option value="Vespertino">Vespertino</option><option value="Nocturno">Nocturno</option></select></div>
            <div class="mb-3"><label for="modalidadEstudio" class="form-label">Modalidad</label><select name="modalidadEstudio" class="form-select"><option value="Virtual">Virtual</option><option value="Presencial">Presencial</option><option value="Mixta">Mixta</option></select></div>
        </div>

        <div id="camposInvestigacion" class="specific-fields">
            <div class="mb-3"><label for="lineaInvestigacion" class="form-label">Línea de Investigación</label><input type="text" name="lineaInvestigacion" class="form-control"></div>
            <div class="mb-3"><label for="nivelAcademico" class="form-label">Nivel Académico</label><select name="nivelAcademico" class="form-select"><option value="Pregrado">Pregrado</option><option value="Postgrado">Postgrado</option></select></div>
            <div class="mb-3"><label for="modalidadInvestigacion" class="form-label">Modalidad</label><select name="modalidadInvestigacion" class="form-select"><option value="Virtual">Virtual</option><option value="Presencial">Presencial</option><option value="Mixta">Mixta</option></select></div>
        </div>
        
        <div id="camposVoluntariado" class="specific-fields">
            <div class="mb-3"><label for="organismoReceptor" class="form-label">Organismo Receptor</label><input type="text" name="organismoReceptor" class="form-control"></div>
            <div class="mb-3"><label for="comunidadBeneficiada" class="form-label">Comunidad Beneficiada</label><input type="text" name="comunidadBeneficiada" class="form-control"></div>
            <div class="mb-3"><label for="lugarActividad" class="form-label">Lugar de la Actividad</label><input type="text" name="lugarActividad" class="form-control"></div>
        </div>

        <button type="submit" class="btn-submit">Crear Grupo</button>
    </form>
</div>

<script>
document.getElementById('tipoGrupo').addEventListener('change', function () {
    // Ocultar todos los grupos de campos específicos
    document.querySelectorAll('.specific-fields').forEach(div => div.style.display = 'none');
    
    // Obtener el valor seleccionado
    const selectedType = this.value;
    
    // Mostrar el grupo de campos correspondiente
    if (selectedType === 'Estudio') {
        document.getElementById('camposEstudio').style.display = 'block';
    } else if (selectedType === 'Investigacion') {
        document.getElementById('camposInvestigacion').style.display = 'block';
    } else if (selectedType === 'Voluntariado') {
        document.getElementById('camposVoluntariado').style.display = 'block';
    }
});
</script>
</body>
</html>