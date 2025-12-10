<?php
/**
 * procesar_crear_grupo.php
 * Ubicación: /src/procesos/procesar_crear_grupo.php
 */

require_once '../libs/verificar_sesion.php'; 
require_once '../db/config_db.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['nombreGrupo']) || empty($_POST['tipoGrupo'])) {
    header("Location: " . URL_ROOT . "/public/CreacionGrupo.php?error=Faltan+datos");
    exit;
}

// --- DATOS GENERALES ---
$numero_aleatorio = mt_rand(10000, 99999);
$ID_grupo = 'RHD-' . $numero_aleatorio;

$nombreGrupo = $_POST['nombreGrupo'];
$descripcion = $_POST['descripcion'];
$cupoMaximo = $_POST['cupoMaximo'];
$tipoGrupo = $_POST['tipoGrupo'];
$IDcreador = $IDusuario;
$fecha = date('Y-m-d H:i:s');

// --- LÓGICA DE ESTADO ---
$estado = 'Activo';
$mensaje_final = "✅ ¡Grupo '{$nombreGrupo}' creado y publicado con éxito!";

if ($tipoGrupo === 'Voluntariado') {
    $estado = 'Pendiente';
    $mensaje_final = "⏳ Grupo creado. Estado: PENDIENTE de validación.";
}

try {
    $conexion->beginTransaction();

    // 1. Insertar en tabla GRUPO (El Dueño)
    $sql_grupo = "INSERT INTO Grupo (ID_grupo, nombreGrupo, descripcion, administradorGrupo, fecha, estado, cupoMaximo) 
                  VALUES (:ID_grupo, :nombreGrupo, :descripcion, :administradorGrupo, :fecha, :estado, :cupoMaximo)";
    $stmt_grupo = $conexion->prepare($sql_grupo);
    $stmt_grupo->execute([
        ':ID_grupo' => $ID_grupo,
        ':nombreGrupo' => $nombreGrupo,
        ':descripcion' => $descripcion,
        ':administradorGrupo' => $IDcreador,
        ':fecha' => $fecha,
        ':estado' => $estado,
        ':cupoMaximo' => $cupoMaximo
    ]);

    // 2. Insertar en tabla ESPECÍFICA (Detalles)
    switch ($tipoGrupo) {
        case 'Estudio':
            $sql_tipo = "INSERT INTO grupoestudio (ID_grupo, Materia, Turno, Modalidad) VALUES (:ID_grupo, :materia, :turno, :modalidad)";
            $stmt_tipo = $conexion->prepare($sql_tipo);
            $stmt_tipo->execute([
                ':ID_grupo' => $ID_grupo,
                ':materia' => $_POST['materia'],
                ':turno' => $_POST['turno'],
                ':modalidad' => $_POST['modalidadEstudio']
            ]);
            break;

        case 'Investigacion':
            $sql_tipo = "INSERT INTO grupoinvestigacion (ID_grupo, LineaInvestigacion, NivelAcademico, Modalidad) VALUES (:ID_grupo, :linea, :nivel, :modalidad)";
            $stmt_tipo = $conexion->prepare($sql_tipo);
            $stmt_tipo->execute([
                ':ID_grupo' => $ID_grupo,
                ':linea' => $_POST['lineaInvestigacion'],
                ':nivel' => $_POST['nivelAcademico'],
                ':modalidad' => $_POST['modalidadInvestigacion']
            ]);
            break;
            
        case 'Voluntariado':
            $sql_tipo = "INSERT INTO grupovoluntariado (ID_grupo, OrganismoReceptor, ComunidadBeneficiada, LugarActividad) VALUES (:ID_grupo, :organismo, :comunidad, :lugar)";
            $stmt_tipo = $conexion->prepare($sql_tipo);
            $stmt_tipo->execute([
                ':ID_grupo' => $ID_grupo,
                ':organismo' => $_POST['organismoReceptor'],
                ':comunidad' => $_POST['comunidadBeneficiada'],
                ':lugar' => $_POST['lugarActividad']
            ]);

            $id_validacion = 'VAL-' . mt_rand(10000, 99999);
            $sql_val = "INSERT INTO validacion (ID_validacion, ID_grupo, estadoValidacion, fechaValidacion) 
                        VALUES (:idval, :idgrupo, 'Pendiente', :fecha)";
            $stmt_val = $conexion->prepare($sql_val);
            $stmt_val->execute([':idval' => $id_validacion, ':idgrupo' => $ID_grupo, ':fecha' => $fecha]);
            break;
    }

    // 3. ¡PASO NUEVO CRÍTICO! AGREGAR AL CREADOR COMO MIEMBRO
    // Esto hace que el conteo inicie en 1 y que aparezcas en la lista de miembros.
    $id_miembro_creador = 'MEM-' . mt_rand(10000, 99999);
    $sql_auto_join = "INSERT INTO miembrosgrupos (ID_miembro, ID_usuario, ID_grupo) VALUES (:idmem, :iduser, :idgrupo)";
    $stmt_auto = $conexion->prepare($sql_auto_join);
    $stmt_auto->execute([
        ':idmem' => $id_miembro_creador,
        ':iduser' => $IDcreador, // Tú eres el usuario
        ':idgrupo' => $ID_grupo
    ]);

    $conexion->commit();

    $_SESSION['mensaje_exito'] = $mensaje_final;
    
    if ($tipoGrupo === 'Voluntariado') {
        header("Location: " . URL_ROOT . "/public/mis_grupos.php");
    } else {
        header("Location: " . URL_ROOT . "/public/Principal.php");
    }
    exit;

} catch (PDOException $e) {
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }
    $_SESSION['mensaje_error'] = "Error al crear el grupo: " . $e->getMessage();
    header("Location: " . URL_ROOT . "/public/CreacionGrupo.php");
    exit;
}
?>