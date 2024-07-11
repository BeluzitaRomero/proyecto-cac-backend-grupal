<?php
// Usamos la conexion que ya establecimos en conexion.php
include '../conexion.php';

// CORS: permitir acceso a la api desde cualquier dominio:
header("Access-Control-Allow-Origin: *"); // Permite acceso desde cualquier origen
header("Content-Type: application/json; charset=UTF-8");


function eliminarPeliculaPorId($id) {
    $conexion = conectar();
    $query = "DELETE FROM pelicula WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $filasAfectadas = mysqli_affected_rows($conexion); 
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    return $filasAfectadas;
}

// Verificar si la solicitud se realizó por DELETE
    if ($_SERVER['REQUEST_METHOD'] === "POST") {   
    //if ($_SERVER["REQUEST_METHOD"] === "DELETE") { no lo soparta el hosting   
    $data = json_decode(file_get_contents('php://input'), true);
    $idPelicula = $data['id'] ?? null;

    if ($idPelicula === null) {
        die(json_encode(['error' => "No se recibió el ID."]));
    }

    // Elimino la película por id
    $filas = eliminarPeliculaPorId($idPelicula);

    if ($filas > 0) {
            echo json_encode(['message' => "Se eliminó la película con el ID $idPelicula"]);
        } else {
            echo json_encode(['error' => "No se encontró ninguna película con el ID proporcionado."]);
        }

} else {
    die(json_encode(['error' => "Solo se admiten solicitudes POST."]));
}

?>
 
