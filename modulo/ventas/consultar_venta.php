<?php

$id = $_GET['id'];

$respuesta = [];

$busqueda = "SELECT v.*,p.EstadoId AS EstadoProducto,p.Nombre,
CONCAT('Nombre: ', p.Nombre, ' - Precio ', p.ValorC, ' - Disp: ') AS NombreProducto 
FROM ventas v
JOIN productos p ON v.ProductoId = p.Id
WHERE v.Id = '$id'";

$consulta = mysqli_query($conexion, $busqueda);
$respuesta = mysqli_error($conexion);

if ($respuesta = mysqli_fetch_assoc($consulta)) {
    // var_dump($respuesta);
    $nom = $respuesta['Nombre'];
    
    $busqueda2 = "SELECT 
    p.Nombre,
    COUNT(*) AS cantidad
    FROM productos p
    WHERE EstadoId = 1 AND p.Nombre='$nom'
    GROUP BY p.Nombre";

    $consulta2 = mysqli_query($conexion, $busqueda2);

    if ($respuesta1 = mysqli_fetch_assoc($consulta2)) {
        $resp = $respuesta1['cantidad'];
        $respuesta['cantidad'] = $resp;
    } else {
        $respuesta['cantidad'] = 0;

    }
   

    echo json_encode($respuesta);
} else {
    //controlar error
}
