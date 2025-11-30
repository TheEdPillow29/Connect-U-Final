<?php
/**
 * CreacionGrupo.php
 * Ubicación: /public/CreacionGrupo.php
 */

// 1. Seguridad de Sesión
require_once '../src/libs/verificar_sesion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Grupo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="../assets/css/Bonito.css" />

    <style>
        body { 
            background: linear-gradient(135deg, #4a148c, #7e57c2); 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px; 
            font-family: 'Segoe UI', sans-serif; 
        }
        .form-container { 
            background-color: #fff; 
            padding: 40px 35px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(74, 20, 140, 0.3); 
            width: 100%; 
            max-width: 580px; 
        }
        h2 { 
            margin-bottom: 30px; 
            font-weight: 700; 
            color: #3b0970; 
            text-align: center; 
        }
        .specific-fields { 
            display: none; /* Oculta los campos específicos por defecto */
            border-left: 3px solid #7e57c2;
            padding-left: 15px;
            margin-left: 5px;
            transition: all 0.3s ease-in-out;
            margin-bottom: 20px;
        }
        .btn-submit { 
            margin-top: 10px; 
            background-color: #4a148c; 
            border: none; 
            width: 100%; 
            padding: 14px; 
            font-weight: 700; 
            color: white; 
            border-radius: 10px;
            transition: background-color 0.2s; 
        }
        .btn-submit:hover {
            background-color: #3b0970;
        }
        .btn-cancel {
            text-decoration: none;
            color: #666;
            display: block;
            text-align: center;
            margin-top: 15px;
            font-weight: 500;
        }
        .btn-cancel:hover { color: #333; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Crear Nuevo Grupo 🚀</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    
    <form action="/ProyectoCoonectU/src/procesos/procesar_crear_grupo.php" method="POST">
        
        <div class="mb-3">
            <label for="nombreGrupo" class="form-label">Nombre del Grupo</label>
            <input type="text" id="nombreGrupo" name="nombreGrupo" class="form-control" required placeholder="Ej: Club de Robótica Avanzada" />
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required placeholder="Describe los objetivos y actividades."></textarea>
        </div>
        <div class="mb-3">
            <label for="cupoMaximo" class="form-label">Cupo Máximo</label>
            <input type="number" id="cupoMaximo" name="cupoMaximo" class="form-control" min="1" required placeholder="Ej: 10" />
        </div>

        <div class="mb-4">
            <label for="tipoGrupo" class="form-label">Tipo de Grupo</label>
            <select id="tipoGrupo" name="tipoGrupo" class="form-select" required>
                <option value="" selected disabled>-- Selecciona un tipo --</option>
                <option value="Estudio">📚 Estudio</option>
                <option value="Investigacion">🔬 Investigación</option>
                <option value="Voluntariado">🌱 Voluntariado</option>
            </select>
        </div>

        <div id="camposEstudio" class="specific-fields">
            <h5 class="text-primary mb-3">Detalles de Estudio</h5>
            <div class="mb-3"><label class="form-label">Materia</label><input type="text" name="materia" class="form-control" placeholder="Ej: Cálculo Integral"></div>
            <div class="mb-3">
                <label class="form-label">Turno</label>
                <select name="turno" class="form-select">
                    <option value="Matutino">Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                    <option value="Nocturno">Nocturno</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Modalidad</label>
                <select name="modalidadEstudio" class="form-select">
                    <option value="Virtual">Virtual</option>
                    <option value="Presencial">Presencial</option>
                    <option value="Mixta">Mixta</option>
                </select>
            </div>
        </div>

        <div id="camposInvestigacion" class="specific-fields">
            <h5 class="text-primary mb-3">Detalles de Investigación</h5>
            <div class="mb-3"><label class="form-label">Línea de Investigación</label><input type="text" name="lineaInvestigacion" class="form-control" placeholder="Ej: IA Aplicada"></div>
            <div class="mb-3">
                <label class="form-label">Nivel Académico</label>
                <select name="nivelAcademico" class="form-select">
                    <option value="Pregrado">Pregrado</option>
                    <option value="Postgrado">Postgrado</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Modalidad</label>
                <select name="modalidadInvestigacion" class="form-select">
                    <option value="Virtual">Virtual</option>
                    <option value="Presencial">Presencial</option>
                    <option value="Mixta">Mixta</option>
                </select>
            </div>
        </div>
        
        <div id="camposVoluntariado" class="specific-fields">
            <h5 class="text-primary mb-3">Detalles de Voluntariado</h5>
            <div class="alert alert-warning small">ℹ️ Los grupos de voluntariado requieren aprobación antes de publicarse.</div>
            <div class="mb-3"><label class="form-label">Organismo Receptor</label><input type="text" name="organismoReceptor" class="form-control" placeholder="Ej: Cruz Roja"></div>
            <div class="mb-3"><label class="form-label">Comunidad Beneficiada</label><input type="text" name="comunidadBeneficiada" class="form-control" placeholder="Ej: Asilo San José"></div>
            <div class="mb-3"><label class="form-label">Lugar de la Actividad</label><input type="text" name="lugarActividad" class="form-control" placeholder="Ej: Centro de la ciudad"></div>
        </div>

        <button type="submit" class="btn btn-submit">Crear Grupo</button>
        <a href="Principal.php" class="btn-cancel">Cancelar</a>
    </form>
</div>

<script>
document.getElementById('tipoGrupo').addEventListener('change', function () {
    // Referencias a los contenedores
    const camposEstudio = document.getElementById('camposEstudio');
    const camposInvestigacion = document.getElementById('camposInvestigacion');
    const camposVoluntariado = document.getElementById('camposVoluntariado');
    
    // Ocultar todos y limpiar 'required'
    document.querySelectorAll('.specific-fields').forEach(div => {
        div.style.display = 'none';
        div.querySelectorAll('input, select').forEach(field => field.removeAttribute('required'));
    });
    
    // Obtener el valor seleccionado
    const selectedType = this.value;
    let targetDiv = null;

    if (selectedType === 'Estudio') targetDiv = camposEstudio;
    else if (selectedType === 'Investigacion') targetDiv = camposInvestigacion;
    else if (selectedType === 'Voluntariado') targetDiv = camposVoluntariado;

    // Mostrar el seleccionado y poner 'required'
    if (targetDiv) {
        targetDiv.style.display = 'block';
        targetDiv.querySelectorAll('input, select').forEach(field => field.setAttribute('required', 'required'));
    }
});
</script>
</body>
</html>