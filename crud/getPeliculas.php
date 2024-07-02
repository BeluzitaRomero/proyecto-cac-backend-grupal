<?php
// Usamos la conexion que ya establecimos en conexion.php
include '../conexion.php';

// CORS: permitir acceso a la api desde cualquier dominio:
header("Access-Control-Allow-Origin: *"); // Permite acceso desde cualquier origen
header("Content-Type: application/json; charset=UTF-8");


// Ejemplo de consulta de películas
$consulta = "SELECT * FROM pelicula";

//la funcion consultar viene de conexion.php
$resultado = consultar($consulta);

// mysqli_num_rows me da el numero de filas que encuentre
if (mysqli_num_rows($resultado) > 0) {
    // Array para almacenar las peliculas encontradas
    $peliculas = [];

    // Iterar sobre los resultados usando mysqli_fetch_assoc
    // y meterlos al array que enviare al front
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $peliculas[] = $fila; // Agregar cada fila al array de películas
    }

    // Convertir el array de películas a formato JSON
    $json_peliculas = json_encode($peliculas);

 

    // Enviar la respuesta JSON al frontend
    header('Content-Type: application/json');
    echo $json_peliculas;
} else {
    // Si no se encontraron películas
    http_response_code(404);
    echo json_encode(array("mensaje" => "No se encontraron películas."));
}
?>
