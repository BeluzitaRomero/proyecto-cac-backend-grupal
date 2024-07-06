<?php
// Usamos la conexion que ya establecimos en conexion.php
// include '../conexion.php';

// // CORS: permitir acceso a la api desde cualquier dominio:
// header("Access-Control-Allow-Origin: *"); 
// header("Content-Type: application/json; charset=UTF-8");


// // Ejemplo de consulta de películas
// $consulta = "SELECT * FROM pelicula";

// //la funcion consultar viene de conexion.php
// $resultado = consultar($consulta);

// // mysqli_num_rows me da el numero de filas que encuentre
// if (mysqli_num_rows($resultado) > 0) {
//     // Array para almacenar las peliculas encontradas
//     $peliculas = [];

//     // Iterar sobre los resultados usando mysqli_fetch_assoc
//     // y meterlos al array que enviare al front
//     while ($fila = mysqli_fetch_assoc($resultado)) {
//         $peliculas[] = $fila; // Agregar cada fila al array de películas
//     }

//     // Convertir el array de películas a formato JSON
//     $json_peliculas = json_encode($peliculas);

 

//     // Enviar la respuesta JSON al frontend
//     header('Content-Type: application/json');
//     echo $json_peliculas;
// } else {
//     // Si no se encontraron películas
//     http_response_code(404);
//     echo json_encode(array("mensaje" => "No se encontraron películas."));
// }

    /* -------------------------------------------------------------------------- */
    /*    version para que me devuelva correctamente los datos freemysqlhosting   */
    /* -------------------------------------------------------------------------- */

include '../conexion.php';

// CORS: permitir acceso a la API desde cualquier dominio
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Verificar la conexión
$conexion = conectar();

if (!$conexion) {
    echo json_encode(array("mensaje" => "Error de conexión: " . mysqli_connect_error()));
    exit();
}

// Asegurarse de que la conexión utiliza UTF-8
mysqli_set_charset($conexion, "utf8");

// Consulta de películas
$consulta = "SELECT * FROM pelicula";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    echo json_encode(array("mensaje" => "Error en la consulta: " . mysqli_error($conexion)));
    mysqli_close($conexion);
    exit();
}

$num_rows = mysqli_num_rows($resultado);

if ($num_rows > 0) {
    $peliculas = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Convertir cada campo a UTF-8 usando mb_convert_encoding (opcional)
        foreach ($fila as $key => $value) {
            $fila[$key] = mb_convert_encoding($value, "UTF-8", "auto");
        }
        $peliculas[] = $fila;
    }

    // Convertir a JSON directamente el array $peliculas
    echo json_encode($peliculas, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
    echo json_encode(array("mensaje" => "No se encontraron películas."));
}

mysqli_close($conexion);



?>
