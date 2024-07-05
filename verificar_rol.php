<?php
// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["mensaje" => "No autorizado"]);
    exit;
}

// Verificar el rol del usuario
if ($_SESSION['rol'] == 'admin') {
    // Código para administradores
    echo json_encode(["mensaje" => "Acceso concedido a administrador"]);
} else {
    // Código para usuarios normales
    echo json_encode(["mensaje" => "Acceso concedido a usuario"]);
}
?>
