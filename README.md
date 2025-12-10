diseñada para conectar a estudiantes 
universitarios, permitiéndoles crear, gestionar y unirse a grupos colaborativos 
de estudio, investigación y voluntariado.

Este proyecto ha sido refactorizado implementando una arquitectura MVC 
(Modelo-Vista-Controlador) simplificada para garantizar seguridad, escalabilidad 
y un código limpio.

--------------------------------------------------------------------------------
                           CARACTERÍSTICAS PRINCIPALES
--------------------------------------------------------------------------------

- Gestión de Usuarios: 
  Registro seguro de estudiantes y sistema de autenticación híbrido (soporta 
  contraseñas antiguas y nuevas encriptadas).

- Creación de Grupos: 
  Los usuarios pueden crear grupos dinámicos con atributos específicos según 
  el tipo (Estudio, Investigación, Voluntariado).

- Sistema de Solicitudes: 
  Los estudiantes pueden solicitar unirse a grupos; las solicitudes quedan en 
  estado "Pendiente" para revisión.

- Panel de Control (Dashboard): 
  Visualización clara de grupos disponibles, cupos y estado de las solicitudes.

- Arquitectura Robusta:
  * Conexión a Base de Datos centralizada (PDO).
  * Sistema de seguridad de sesiones centralizado.
  * Protección contra Inyección SQL y XSS.

--------------------------------------------------------------------------------
                             TECNOLOGÍAS UTILIZADAS
--------------------------------------------------------------------------------

- Backend: PHP 8 (Nativo, sin frameworks).
- Base de Datos: MySQL / MariaDB.
- Frontend: HTML5, CSS3 (Diseño personalizado "Bonito.css") y Bootstrap 5.
- Servidor Local: XAMPP (Apache).

--------------------------------------------------------------------------------
                            ESTRUCTURA DEL PROYECTO
--------------------------------------------------------------------------------

/ProyectoCoonectU
+-- /assets          (Archivos estáticos: CSS, JS, Imágenes)
+-- /public          (Vistas públicas: Login, Principal... Lo que ve el usuario)
+-- /src             (Lógica del servidor: Backend)
|   +-- /db          (Configuración de base de datos)
|   +-- /libs        (Librerías de seguridad y utilidades)
|   +-- /procesos    (Scripts que procesan datos: Login, Registro, Creación)
+-- README.txt       (Este archivo de documentación)

--------------------------------------------------------------------------------
                        GUÍA DE INSTALACIÓN Y DESPLIEGUE
--------------------------------------------------------------------------------

Sigue estos pasos para ejecutar el proyecto en tu máquina local.

1. REQUISITOS PREVIOS
   - Tener instalado XAMPP (o WAMP/MAMP) con PHP 8.0+ y MySQL.
   - Tener los servicios de Apache y MySQL iniciados.

2. CLONAR O COPIAR EL REPOSITORIO
   Descarga el código y mueve la carpeta "ProyectoCoonectU" dentro de la 
   carpeta pública de tu servidor:
   - En XAMPP: C:\xampp\htdocs\
   - En WAMP:  C:\wamp64\www\

3. IMPORTAR LA BASE DE DATOS
   El sistema requiere la estructura de base de datos para funcionar.
   a. Abre phpMyAdmin (usualmente en http://localhost/phpmyadmin).
   b. Crea una nueva base de datos llamada: "sistemagruposv2" (sin comillas).
   c. Selecciona la base de datos creada y ve a la pestaña "Importar".
   d. Selecciona el archivo .sql incluido en el proyecto y pulsa "Continuar".

4. CONFIGURAR LA CONEXIÓN (IMPORTANTE)
   Si tu configuración de MySQL es diferente a la estándar, edita el archivo:
   Ruta: src/db/config_db.php

   Asegúrate de que los valores coincidan con tu XAMPP:
   - DB_PORT: 3306 (o 3307 si lo cambiaste)
   - DB_USER: root
   - DB_PASS: (generalmente vacío)
   - URL_ROOT: /ProyectoCoonectU

5. ¡EJECUTAR!
   Abre tu navegador web y accede a la siguiente dirección:
   http://localhost/ProyectoCoonectU/public/Login.html

--------------------------------------------------------------------------------
                              USUARIOS DE PRUEBA
--------------------------------------------------------------------------------

Si has importado la base de datos de ejemplo, puedes probar el acceso con:

- Correo:      test@correo.com (o puedes registrar uno nuevo)
- Contraseña:  123456

================================================================================

