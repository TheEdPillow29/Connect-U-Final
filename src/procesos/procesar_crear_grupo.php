<?php
/**
 * procesar_crear_grupo.php
 * Procesa el formulario de CreacionGrupo.php y realiza las inserciones en la base de datos
 * usando transacciones PDO.
 * Ubicación: /src/procesos/procesar_crear_grupo.php
 */

// 1. MODULO DE SEGURIDAD: Inicia sesión, verifica la autenticación y nos provee $IDusuario.
// Sube un nivel (..) para entrar a 'src/libs'
include '../libs/verificar_sesion.php'; 

// 2. MODULO DE CONEXIÓN: Conecta con la DB. Nos provee $conexion.
// Sube un nivel (..) para entrar a 'src/db'
include '../db/config_db.php'; 

// La variable $IDusuario y $conexion ya están disponibles

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['nombreGrupo']) || empty($_POST['tipoGrupo'])) {
    // Redirección si faltan datos esenciales o no es un POST válido
    header("Location: ../public/CreacionGrupo.php?error=Faltan+datos");
    exit;
}

// 3. CAPTURA DE DATOS
$numero_aleatorio = mt_rand(10000, 99999);
$ID_grupo = 'RHD-' . $numero_aleatorio; // Generación de ID único

$nombreGrupo = $_POST['nombreGrupo'];
$descripcion = $_POST['descripcion'];
$cupoMaximo = $_POST['cupoMaximo'];
$tipoGrupo = $_POST['tipoGrupo'];
$IDcreador = $IDusuario; // Tomado del módulo de sesión
$fecha = date('Y-m-d H:i:s');
$estado = 'Activo';

// 4. INICIO DE TRANSACCIÓN (Para asegurar que todas las inserciones sean exitosas o ninguna)
try {
    $conexion->beginTransaction();

    // Insertar en la tabla principal 'Grupo'
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

    // Insertar en la tabla específica del tipo de grupo
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
            break;
    }

    // Si todo fue bien, confirmar los cambios
    $conexion->commit();

    // 5. REDIRECCIÓN DE ÉXITO (Reemplaza el bloque HTML de éxito)
    // Guardar mensaje de éxito en la sesión
    $_SESSION['mensaje_exito'] = "✅ ¡Grupo '{$nombreGrupo}' creado con éxito!";

    // Redirigir a la página principal (RUTA AJUSTADA)
    header("Location: ../public/Principal.php"); 
    exit;

} catch (PDOException $e) {
    // 6. MANEJO DE ERROR Y ROLLBACK
    if ($conexion->inTransaction()) {
        $conexion->rollBack(); // Deshacer todos los cambios en la DB
    }
    
    // Guardar mensaje de error en la sesión y redirigir al formulario de creación (RUTA AJUSTADA)
    $_SESSION['mensaje_error'] = "❌ Error al crear el grupo: " . $e->getMessage();
    header("Location: ../public/CreacionGrupo.php?error=db");
    exit;
}
?>