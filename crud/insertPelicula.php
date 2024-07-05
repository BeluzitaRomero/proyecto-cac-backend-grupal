<?php
include '../conexion.php';
include '../utils/subirImgbb.php';

// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Indicar que la respuesta contiene datos JSON
header("Content-Type: application/json; charset=UTF-8");

// Verifico solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Campos del form
    $titulo = $_POST['titulo'] ?? '';
    $sinopsis = $_POST['sinopsis'] ?? '';
    $estreno = $_POST['estreno'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $idioma = $_POST['idioma'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $imagen_temporal = $_FILES['imagen']['tmp_name'] ?? '';

    // Subir la imagen a ImgBB
    if (!empty($imagen_temporal)) {
        $url_imagen = subirImagenAImgBB($imagen_temporal);
        if (!$url_imagen) {
            die("Error al subir la imagen a ImgBB.");
        }
    } else {
        die("Error: No se recibió ninguna imagen.");
    }


    // Usamos la funcion de conectar de conexion.php
    $conexion =conectar();
    $query = "INSERT INTO pelicula (titulo, sinopsis, img, estreno, genero, idioma, duracion) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);

    // Asignar los parámetros y ejecutar la consulta preparada
    //el segundo parametro verifica los titulos de datos, string, string, ..., int
    mysqli_stmt_bind_param($stmt, "ssssssi", $titulo, $sinopsis, $url_imagen, $estreno, $genero, $idioma, $duracion);
    $exito = mysqli_stmt_execute($stmt);

    // Verificar si la inserción fue exitosa
    if ($exito) {
        echo "La película se insertó correctamente.";
    } else {
        echo "Error al insertar la película: " . mysqli_error($conexion);
    }

    // Cerrar la conexión y liberar recursos
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>
