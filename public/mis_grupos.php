<?php
/**
 * mis_grupos.php
 * Muestra los grupos de los que el usuario es Miembro o Administrador.
 * Ubicación: /public/mis_grupos.php
 */

// 1. MÓDULO DE SEGURIDAD: iniciar sesión y verificar autenticación.
include_once '../src/libs/verificar_sesion.php';

// 2. MÓDULO DE CONEXIÓN: conectar con la DB.
include_once '../src/db/config_db.php';

// El ID del usuario ya viene desde verificar_sesion.php
$IDusuario = $IDusuario;

// CONSULTA SQL
$sql = "
SELECT 
  g.ID_grupo,
  g.nombreGrupo,
  g.descripcion,
  g.estado,
  g.tipoGrupo,
  g.fecha,

  CASE 
    WHEN g.administradorGrupo = :IDusuario THEN 'Administrador'
    ELSE 'Miembro'
  END AS RolEnGrupo,

  ge.Materia,
  ge.Turno,
  ge.Modalidad,

  gi.LineaInvestigacion,
  gi.NivelAcademico,
  gi.Modalidad AS ModalidadInvestigacion,

  gv.ID_responsable,
  gv.OrganismoReceptor,
  gv.ComunidadBeneficiada,
  gv.LugarActividad

FROM Grupo g

LEFT JOIN MiembrosGrupos mg 
       ON g.ID_grupo = mg.ID_grupo AND mg.ID_usuario = :IDusuario

LEFT JOIN GrupoEstudio ge 
       ON g.ID_grupo = ge.ID_grupo

LEFT JOIN GrupoInvestigacion gi 
       ON g.ID_grupo = gi.ID_grupo

LEFT JOIN GrupoVoluntariado gv 
       ON g.ID_grupo = gv.ID_grupo

WHERE (g.administradorGrupo = :IDusuario OR mg.ID_usuario = :IDusuario)
ORDER BY g.fecha DESC
";

$stmt = $conexion->prepare($sql);
$stmt->execute(['IDusuario' => $IDusuario]);
$grupos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Mis Grupos</title>

<!-- CSS externo -->
<link rel="stylesheet" href="../assets/css/Bonito.css">

<!-- Estilos inline -->
<style>
  body { 
    font-family: Arial, sans-serif; 
    background: #f4f6f8; 
    margin: 0; 
    padding: 20px; 
  }

  .container { 
    max-width: 900px; 
    margin: auto; 
  }

  h1 { 
    text-align: center; 
    color: #333; 
    margin-bottom: 30px; 
  }

  .grupo-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 8px solid;
  }
</style>

</head>
<body>

  <div class="container">
    <h1>Mis Grupos</h1>

    <?php if (count($grupos) === 0): ?>
      <p>No estás participando en ningún grupo.</p>
    <?php else: ?>

      <?php foreach ($grupos as $g): ?>
        <div class="grupo-card">
          <h2><?= htmlspecialchars($g['nombreGrupo']) ?></h2>
          <p><strong>Rol:</strong> <?= $g['RolEnGrupo'] ?></p>
          <p><strong>Tipo:</strong> <?= $g['tipoGrupo'] ?></p>
          <p><strong>Descripción:</strong> <?= htmlspecialchars($g['descripcion']) ?></p>
          <p><strong>Fecha:</strong> <?= $g['fecha'] ?></p>

          <?php if ($g['tipoGrupo'] === 'Estudio'): ?>
            <p><strong>Materia:</strong> <?= $g['Materia'] ?></p>
            <p><strong>Turno:</strong> <?= $g['Turno'] ?></p>
            <p><strong>Modalidad:</strong> <?= $g['Modalidad'] ?></p>

          <?php elseif ($g['tipoGrupo'] === 'Investigacion'): ?>
            <p><strong>Línea de investigación:</strong> <?= $g['LineaInvestigacion'] ?></p>
            <p><strong>Nivel académico:</strong> <?= $g['NivelAcademico'] ?></p>
            <p><strong>Modalidad:</strong> <?= $g['ModalidadInvestigacion'] ?></p>

          <?php elseif ($g['tipoGrupo'] === 'Voluntariado'): ?>
            <p><strong>Organismo Receptor:</strong> <?= $g['OrganismoReceptor'] ?></p>
            <p><strong>Comunidad:</strong> <?= $g['ComunidadBeneficiada'] ?></p>
            <p><strong>Lugar:</strong> <?= $g['LugarActividad'] ?></p>

          <?php endif; ?>
        </div>
      <?php endforeach; ?>

    <?php endif; ?>
  </div>

</body>
</html>
