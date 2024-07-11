<?php
// Usamos la conexión que ya establecimos en conexion.php
include '../conexion.php';

// CORS: permitir acceso a la API desde cualquier dominio
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Función para obtener una película por su ID
function obtenerPeliculaPorId($id) {
    $conexion = conectar();

    // Establecer el conjunto de caracteres a UTF-8 después de la conexión
    mysqli_set_charset($conexion, "utf8");

    $query = "SELECT * FROM pelicula WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $pelicula = mysqli_fetch_assoc($resultado);

    // Convertir cada campo a UTF-8 usando mb_convert_encoding
    foreach ($pelicula as $key => $value) {
        $pelicula[$key] = mb_convert_encoding($value, "UTF-8", "auto");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    return $pelicula;
}

// Verificar si la solicitud se realizó por GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $idPelicula = $_GET['id'] ?? null;
    
    if ($idPelicula === null) {
        http_response_code(400);
        echo json_encode(['error' => "No se recibió el ID."]);
        exit;
    }

    // Obtener la película por su ID
    $peliculaEncontrada = obtenerPeliculaPorId($idPelicula);

    if ($peliculaEncontrada) {
        echo json_encode($peliculaEncontrada, JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'No se encontró ninguna película con el ID proporcionado.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => "Solo se admiten solicitudes GET."]);
}
?>
