<?php
// Función para subir una imagen a ImgBB y devolver el URL de la imagen
function subirImagenAImgBB($imagen_temporal, $tipo = "noBase64") {
    $api_key = '4e909fe2db5c16069eff2f72188a60a3'; // produccion

    //$api_key = ''; // testing

    $endpoint = 'https://api.imgbb.com/1/upload';

    if ($tipo === "base64") {
        $imagen_base64 = $imagen_temporal;
    } else {
        $imagen_base64 = base64_encode(file_get_contents($imagen_temporal));
    }

    $datos = array(
        'key' => $api_key,
        'image' => $imagen_base64
    );

    $opciones = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($datos)
        )
    );

    $contexto = stream_context_create($opciones);
    $resultado = file_get_contents($endpoint, false, $contexto);

    if ($resultado === FALSE) {
        return false;
    } else {
        $respuesta = json_decode($resultado, true);
        return $respuesta['data']['url']; // Devuelve el URL de la imagen subida
    }
}

?>