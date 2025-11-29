<?php
$host = '127.0.0.1';      // Usar IP directa evita problemas de socket
$port = 3307;             
$user = 'AdministradorWeb';
$pass = 'h9!(pZ.P2GYYbFe/';     // Usa aquí la contraseña correcta
$db   = 'sistemagruposv2';

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa";
}
?>