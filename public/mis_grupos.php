<?php
/**
 * mis_grupos.php
 * Ubicación: /public/mis_grupos.php
 */

require_once '../src/libs/verificar_sesion.php'; 
require_once '../src/db/config_db.php'; 

// --- CONSULTA SQL ---
$sql = "
SELECT 
  g.ID_grupo, g.nombreGrupo, g.descripcion, g.fecha, g.cupoMaximo,
  CASE 
    WHEN ge.ID_grupo IS NOT NULL THEN 'Estudio'
    WHEN gi.ID_grupo IS NOT NULL THEN 'Investigación'
    WHEN gv.ID_grupo IS NOT NULL THEN 'Voluntariado'
    ELSE 'Otro'
  END AS tipoGrupo,
  CASE 
    WHEN g.administradorGrupo = :IDusuario THEN 'Administrador'
    ELSE 'Miembro'
  END AS MiRol,
  ge.Materia, ge.Turno, ge.Modalidad AS ModEstudio,
  gi.LineaInvestigacion, gi.NivelAcademico, gi.Modalidad AS ModInvest,
  gv.OrganismoReceptor, gv.ComunidadBeneficiada, gv.LugarActividad,
  lider.nombre AS LiderNombre, lider.correo AS LiderCorreo, lider.Numtelefono AS LiderTelefono
FROM Grupo g
LEFT JOIN MiembrosGrupos mg ON g.ID_grupo = mg.ID_grupo
LEFT JOIN GrupoEstudio ge ON g.ID_grupo = ge.ID_grupo
LEFT JOIN GrupoInvestigacion gi ON g.ID_grupo = gi.ID_grupo
LEFT JOIN GrupoVoluntariado gv ON g.ID_grupo = gv.ID_grupo
LEFT JOIN usuario lider ON g.administradorGrupo = lider.IDusuario
WHERE g.administradorGrupo = :IDusuario OR mg.ID_usuario = :IDusuario
GROUP BY g.ID_grupo
ORDER BY g.fecha DESC
";

$stmt = $conexion->prepare($sql);
$stmt->execute(['IDusuario' => $IDusuario]);
$misGrupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Grupos | Connect-U</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- CSS Base -->
    <link rel="stylesheet" href="../assets/css/Bonito.css">

    <style>
        /* --- ESTILOS DE ALTO CONTRASTE (Igual que Mis Solicitudes) --- */
        body {
            background-color: #f0f0f0; 
            display: block !important;
        }

        /* BANNER SUPERIOR */
        .header-banner {
            background-color: #6f2c91; /* Morado Connect-U */
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

        /* CONTENEDOR */
        .container-dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 40px 20px;
        }

        /* TARJETAS DE GRUPO */
        .group-card {
            background: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .group-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        /* CABECERA DE TARJETA (Color Sólido según Rol) */
        .card-header-role {
            padding: 15px 20px;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bg-admin-header { background-color: #6f2c91; } /* Morado para Admin */
        .bg-member-header { background-color: #0d6efd; } /* Azul para Miembro */

        .card-body-custom {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        /* ETIQUETA DE TIPO (Estudio, etc.) */
        .badge-tipo {
            background-color: #eee;
            color: #555;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* BOTÓN DE ACCIÓN */
        .btn-action-card {
            margin: 0 20px 20px 20px;
            padding: 12px;
            background-color: white;
            border: 2px solid #6f2c91;
            color: #6f2c91;
            font-weight: 700;
            border-radius: 50px;
            transition: all 0.2s;
        }
        .btn-action-card:hover {
            background-color: #6f2c91;
            color: white;
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

        /* MODAL STYLES */
        .modal-header-custom { background-color: #6f2c91; color: white; }
        .detail-label { font-weight: 700; color: #555; font-size: 0.85rem; text-transform: uppercase; }
        .contact-box { background-color: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #eee; }
    </style>
</head>
<body>

    <!-- 1. BANNER SUPERIOR -->
    <div class="header-banner">
        <h1 class="header-title">
            <span class="icon-header">👥</span> Mis Grupos Activos
        </h1>
    </div>

    <div class="container-dashboard">

        <?php if (count($misGrupos) === 0): ?>
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <div style="font-size: 4rem;">📂</div>
                <h3 class="mt-3 text-muted">No perteneces a ningún grupo</h3>
                <p class="text-secondary mb-4">Explora la comunidad y únete a un grupo de estudio o voluntariado.</p>
                <a href="Principal.php" class="btn btn-primary px-4 py-2 rounded-pill">Explorar Grupos</a>
            </div>
        <?php else: ?>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($misGrupos as $g): ?>
                    <div class="col">
                        <div class="group-card">
                            
                            <!-- CABECERA DE COLOR SÓLIDO -->
                            <div class="card-header-role <?= $g['MiRol'] === 'Administrador' ? 'bg-admin-header' : 'bg-member-header' ?>">
                                <span><?= strtoupper($g['MiRol']) ?></span>
                                <span class="badge-tipo"><?= htmlspecialchars($g['tipoGrupo']) ?></span>
                            </div>

                            <div class="card-body-custom">
                                <!-- Título -->
                                <h3 class="fw-bold h5 mb-3 text-dark"><?= htmlspecialchars($g['nombreGrupo']) ?></h3>
                                
                                <!-- Descripción Corta -->
                                <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6;">
                                    <?= mb_strlen($g['descripcion']) > 90 ? mb_substr($g['descripcion'], 0, 90) . '...' : htmlspecialchars($g['descripcion']) ?>
                                </p>

                                <!-- Meta Info -->
                                <div class="d-flex justify-content-between text-muted small border-top pt-3">
                                    <span>📅 <?= (new DateTime($g['fecha']))->format('d/m/Y') ?></span>
                                    <span>👥 Cupo: <?= $g['cupoMaximo'] ?></span>
                                </div>
                            </div>

                            <!-- Botón de Acción -->
                            <button type="button" class="btn-action-card" 
                                    data-bs-toggle="modal" data-bs-target="#modalDetalle<?= $g['ID_grupo'] ?>">
                                Ver Detalles Completos
                            </button>
                        </div>
                    </div>

                    <!-- MODAL DE DETALLES (Igual de funcional, estilo ajustado) -->
                    <div class="modal fade" id="modalDetalle<?= $g['ID_grupo'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                                <div class="modal-header modal-header-custom">
                                    <h5 class="modal-title fw-bold"><?= htmlspecialchars($g['nombreGrupo']) ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row g-4">
                                        <!-- Detalles -->
                                        <div class="col-md-7 border-end">
                                            <h6 class="text-primary fw-bold text-uppercase small mb-3">Información Operativa</h6>
                                            <p class="text-secondary mb-4"><?= nl2br(htmlspecialchars($g['descripcion'])) ?></p>
                                            
                                            <div class="row g-3">
                                                <?php if ($g['tipoGrupo'] === 'Estudio'): ?>
                                                    <div class="col-6"><div class="detail-label">Materia</div><div><?= $g['Materia'] ?></div></div>
                                                    <div class="col-6"><div class="detail-label">Horario</div><div><?= $g['Turno'] ?></div></div>
                                                    <div class="col-12"><div class="detail-label">Modalidad</div><div><?= $g['ModEstudio'] ?></div></div>
                                                <?php elseif ($g['tipoGrupo'] === 'Investigación'): ?>
                                                    <div class="col-6"><div class="detail-label">Línea</div><div><?= $g['LineaInvestigacion'] ?></div></div>
                                                    <div class="col-6"><div class="detail-label">Nivel</div><div><?= $g['NivelAcademico'] ?></div></div>
                                                    <div class="col-12"><div class="detail-label">Modalidad</div><div><?= $g['ModInvest'] ?></div></div>
                                                <?php elseif ($g['tipoGrupo'] === 'Voluntariado'): ?>
                                                    <div class="col-6"><div class="detail-label">Organismo</div><div><?= $g['OrganismoReceptor'] ?></div></div>
                                                    <div class="col-6"><div class="detail-label">Comunidad</div><div><?= $g['ComunidadBeneficiada'] ?></div></div>
                                                    <div class="col-12"><div class="detail-label">Lugar</div><div><?= $g['LugarActividad'] ?></div></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Contacto -->
                                        <div class="col-md-5">
                                            <div class="contact-box h-100">
                                                <h6 class="fw-bold mb-3 text-dark">📞 Líder del Grupo</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center fw-bold text-white bg-primary" 
                                                         style="width: 45px; height: 45px; font-size: 1.2rem; margin-right: 15px;">
                                                        <?= strtoupper(substr($g['LiderNombre'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark"><?= htmlspecialchars($g['LiderNombre']) ?></div>
                                                        <span class="badge bg-secondary rounded-pill" style="font-size: 0.65rem;">ADMINISTRADOR</span>
                                                    </div>
                                                </div>
                                                <div class="d-grid gap-2">
                                                    <a href="mailto:<?= $g['LiderCorreo'] ?>" class="btn btn-outline-dark btn-sm">📧 Enviar Correo</a>
                                                    <?php if(!empty($g['LiderTelefono'])): ?>
                                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $g['LiderTelefono']) ?>" target="_blank" class="btn btn-outline-success btn-sm">💬 WhatsApp</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Modal -->

                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- Botón Volver Flotante -->
    <a href="Principal.php" class="btn-back-floating">⬅ Volver al Inicio</a>

</body>
</html>