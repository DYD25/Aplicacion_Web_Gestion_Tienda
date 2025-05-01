<?php
global $conexion;
$id = $_POST['id'];

$eliminar = "DELETE FROM personas WHERE Id='$id'";

mysqli_query($conexion, $eliminar);
$resultado = [];
if (mysqli_error($conexion) == "") {
    $resultado['error'] = false;
} else {
    $resultado['error'] = true;
    $resultado['mensaje'] = mysqli_error($conexion);
}



echo json_encode($resultado);
