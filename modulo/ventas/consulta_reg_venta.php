<?php

$pro = $_GET['p'];
$can = $_GET['c'];

$resultado = [];

$busqueda = "SELECT * FROM productos
 WHERE Id='$pro'";

$consulta = mysqli_query($conexion, $busqueda);
$rw = mysqli_fetch_array($consulta);

$nomp = $rw['Nombre'];
$valor = $rw['ValorV'];

$busqueda2 = "SELECT count(*) canti FROM productos
 WHERE Nombre='$nomp' and EstadoId=1";

$consulta2 = mysqli_query($conexion, $busqueda2);
$rw2 = mysqli_fetch_array($consulta2);

$cant = $rw2['canti'];

if ($cant >= $can) {
    $valorPag = $valor * $can;
    $resultado['error'] = false;
    $resultado['precio'] = $valorPag;
} else {
    $resultado['error'] = true;
}

echo json_encode($resultado);
