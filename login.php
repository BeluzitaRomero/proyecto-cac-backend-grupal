<?php 
include 'conexion.php';
session_start(); // Iniciar la sesión

// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Verificar solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar los datos
    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo json_encode(["mensaje" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Consultar el usuario en la base de datos
    $conexion = conectar();

    // Consulta preparada para evitar SQL injection
    $query = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Verificar si se encontró el usuario
    if ($row = mysqli_fetch_assoc($resultado)) {
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Contraseña correcta
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['rol'] = $row['rol']; 
            
            http_response_code(200);
            echo json_encode(["mensaje" => "Inicio de sesión exitoso",
                "user_id" => $row['id'],
                "username" => $row['username'],
                "rol" => $row['rol']]);
            
        } else {
            // Contraseña incorrecta
            http_response_code(401);
            echo json_encode(["mensaje" => "Contraseña incorrecta"]);
        }
    } else {
        // Usuario no encontrado
        http_response_code(404);
        echo json_encode(["mensaje" => "Usuario no encontrado"]);
    }

    // Cerrar la conexión y liberar recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    // Método no permitido
    http_response_code(405);
    echo json_encode(["mensaje" => "Método no permitido"]);
}
?>
