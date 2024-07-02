<?php
include 'conexion.php';

// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Verificar solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Campos del formulario
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar los datos
    if (empty($username) || empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(["mensaje" => "Todos los campos son obligatorios"]);
        exit;
    }

    // Verificar si el usuario ya existe
    $consulta = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = consultar($consulta);

    if (mysqli_num_rows($resultado) > 0) {
        http_response_code(409);
        echo json_encode(["mensaje" => "El usuario ya existe"]);
        exit;
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $conexion = conectar();
    $query = "INSERT INTO usuarios (username, email, password, rol) VALUES (?, ?, ?, 'usuario')";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        http_response_code(201);
        echo json_encode(["mensaje" => "Registro exitoso"]);
    } else {
        http_response_code(500);
        echo json_encode(["mensaje" => "Error al registrar el usuario: " . mysqli_error($conexion)]);
    }

    // Cerrar la conexión y liberar recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    http_response_code(405);
    echo json_encode(["mensaje" => "Método no permitido"]);
}
?>
