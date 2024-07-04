<?php
// Usamos la conexion que ya establecimos en conexion.php
include '../conexion.php';

// CORS: permitir acceso a la api desde cualquier dominio:
header("Access-Control-Allow-Origin: *"); // Permite acceso desde cualquier origen
header("Content-Type: application/json; charset=UTF-8");


function obtenerPeliculaPorId($id) {
    $conexion = conectar();
    $query = "SELECT * FROM pelicula WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $pelicula = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    return $pelicula;
}

// Verifico si la solicitud se realizó por GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $idPelicula = $_GET['id'] ?? null;
    if ($idPelicula === null) {
        die(json_encode(['error' => "No se recibió el ID."]));
    }

    // Obtengo la película por id
    $peliculaEncontrada = obtenerPeliculaPorId($idPelicula);

    if ($peliculaEncontrada) {
        header('Content-Type: application/json');
        echo json_encode($peliculaEncontrada);
    } else {
        echo json_encode(['error' => 'No se encontró ninguna película con el ID proporcionado.']);
    }
} else {
    die(json_encode(['error' => "Solo se admiten solicitudes GET."]));
}

?>
