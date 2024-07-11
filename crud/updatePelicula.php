<?php
// Usamos la conexion que ya establecimos en conexion.php
include '../conexion.php';
include '../utils/subirImgbb.php';

// CORS: permitir acceso a la api desde cualquier dominio:
header("Access-Control-Allow-Origin: *"); // Permite acceso desde cualquier origen
header("Content-Type: application/json; charset=UTF-8");


function modificarPeliculaPorId($id, $titulo, $sinopsis, $url_imagen, $estreno, $genero, $idioma, $duracion) {
    $conexion =conectar();
    $query = "UPDATE pelicula SET titulo=?, sinopsis=?, img=?, estreno=?, genero=?, idioma=?, duracion=? WHERE id=?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ssssssii", $titulo, $sinopsis, $url_imagen, $estreno, $genero, $idioma, $duracion, $id);
    mysqli_stmt_execute($stmt);
    $filasAfectadas = mysqli_affected_rows($conexion); 
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    return $filasAfectadas;

}

// Verifico si la solicitud se realizó por PUT
if ($_SERVER['REQUEST_METHOD'] === "POST") {
//  if ($_SERVER['REQUEST_METHOD'] === "PUT") { no lo soparta el hosting
    $data = json_decode(file_get_contents('php://input'), true);
    $idPelicula = $data['id'] ?? null;
    if ($idPelicula === null) {
        http_response_code(400);
        die(json_encode(['error' => "No se recibió el ID."]));
    }
    
    // Camposdatos del json
    $titulo = $data['titulo'] ?? '';
    $sinopsis = $data['sinopsis'] ?? '';
    $estreno = $data['estreno'] ?? '';
    $genero = $data['genero'] ?? '';
    $idioma = $data['idioma'] ?? '';
    $duracion = $data['duracion'] ?? '';
    $url_imagen = $data['url_imagen'] ?? '';
    $imagenBase64 = $data['imagenBase64'] ?? null;

    if (!empty($imagenBase64)) {
        $url_tmp = subirImagenAImgBB($imagenBase64, "base64");

        if (!$url_tmp) {
            die(json_encode(['error' => "Error al subir la imagen a ImgBB."]));
        } else {
            $url_imagen = $url_tmp;
        }
                
    }


    // Modifico la película por id
     $filas = modificarPeliculaPorId($idPelicula, $titulo, $sinopsis, $url_imagen, $estreno, $genero, $idioma, $duracion);

     if ($filas > 0) {
             http_response_code(200);
             echo json_encode(['message' => "Se modificó la película con el ID $idPelicula"]);
         } else {
            http_response_code(404);
             echo json_encode(['error' => "No se realizaron cambios."]);
         }
 
} else {
    http_response_code(405);
    echo json_encode(['error' => "Solo se admiten solicitudes POST."]);
}

?>
