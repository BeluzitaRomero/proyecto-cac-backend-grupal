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

// // Crear usuario admin
// function crearAdmin() {
//     $conexion = conectar();

//     // Hashear la contraseña
//     $admin_password ="admin123"; // Cambia esto a la contraseña que desees
//     $hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

//     // Verificar si el usuario admin ya existe
//     $checkAdminQuery = "SELECT * FROM usuarios WHERE username = 'admin'";
//     $checkResult = mysqli_query($conexion, $checkAdminQuery);

//     if (mysqli_num_rows($checkResult) == 0) {
//         // Insertar el usuario admin
//         $insertAdminQuery = "INSERT INTO usuarios (username, email, password, rol) VALUES ('admin', 'admin@example.com', '$hashed_password', 'admin')";

//         if (mysqli_query($conexion, $insertAdminQuery)) {
//             echo "Usuario admin creado exitosamente";
//         } else {
//             echo "Error: " . $insertAdminQuery . "<br>" . mysqli_error($conexion);
//         }
//     } else {
//         echo "El usuario admin ya existe.";
//     }

//     mysqli_close($conexion);
// }

// // Ejecutar la creación del admin
// crearAdmin();


?>
