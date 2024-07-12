<?php
// Incluir el archivo de conexión

//VERSION 1, sin usar "consultar" ya que cerraba la conexion antes de su proceso completo
// include '../conexion.php';

// // CORS: permitir acceso a la API desde cualquier dominio
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

// // Establecer la conexión (esta parte está en conexión.php)
// $conexion = conectar(); // Utilizando la función conectar del archivo conexion.php

// // Verificar si la conexión se estableció correctamente
// if (!$conexion) {
//     die(json_encode(array("mensaje" => "Error de conexión: " . mysqli_connect_error())));
// }

// // Asegurarse de que la conexión utiliza UTF-8
// mysqli_set_charset($conexion, "utf8");

// // Consulta de películas
// $consulta = "SELECT * FROM pelicula";
// $resultado = mysqli_query($conexion, $consulta);

// // Verificar si hubo resultados
// if ($resultado && mysqli_num_rows($resultado) > 0) {
//     $peliculas = [];

//     // Iterar sobre los resultados usando mysqli_fetch_assoc
//     while ($fila = mysqli_fetch_assoc($resultado)) {
//         $peliculas[] = $fila; // Agregar cada fila al array de películas
//     }

//     // Convertir el array de películas a formato JSON
//     $json_peliculas = json_encode($peliculas, JSON_UNESCAPED_UNICODE);

//     // Enviar la respuesta JSON al frontend
//     header('Content-Type: application/json');
//     echo $json_peliculas;
// } else {
//     // Si no se encontraron películas
//     http_response_code(404);
//     echo json_encode(array("mensaje" => "No se encontraron películas."));
// }

// // Cerrar la conexión
// mysqli_close($conexion);

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
