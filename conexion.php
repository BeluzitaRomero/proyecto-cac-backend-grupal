<?php 
//funciones de conexion

/*PARAMETROS UE NECESITA LA FUNC mysqli_connect:
1. Lugar donde esta alojada mi db (nosotros usamos xampp)-> "localhost"
1.a. Si yo decido contratar un servicio para la DDBB, ahi cambiaría.

2. Nombre de usuario de la DDBB: "root" (el nombre de usuario de xampp)
3. Contraseña de la DDBB: "" (por defecto en xampp "")
4. Nombre de mi DDBB: peliculas_db

*/

function conectar() {
    $conexion = mysqli_connect("localhost", "root", "", "peliculas_db");

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    return $conexion;
}

// Función para ejecutar consultas SELECT
function consultar($consulta) {
    $conexion = conectar();
    $resultado = mysqli_query($conexion, $consulta);
    mysqli_close($conexion); // Cerrar la conexión después de usarla
    return $resultado;
}



?>
