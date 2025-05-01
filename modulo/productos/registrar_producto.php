<?php
global $conexion;

$cod = $_POST['code'];
$des = $_POST['des'];
$nomb = $_POST['nom'];
$valc = $_POST['valc'];
$valv = $_POST['valv'];
$est = $_POST['est'];
 
$resultado = [];

if (!empty($cod) && !empty($des) && !empty($nomb) && !empty($valc) && !empty($valv) && !empty($est)) {

  $busqueda = "select * from productos where Codigo = '$cod'";
  $consulta = mysqli_query($conexion, $busqueda);
  $rw = mysqli_fetch_array($consulta);

  if (empty($rw)) {

    $insetar = "INSERT INTO productos (Descripcion,Nombre,ValorC,ValorV,Codigo,EstadoId,Fecha) 
    VALUES('$des','$nomb','$valc','$valv','$cod','$est',NOW())";

    $rs2 = mysqli_query($conexion, $insetar);

    if (mysqli_error($conexion) == "") {

      $resultado['error'] = false;
    } else {
      $resultado['error'] = true;
      $resultado['mensaje'] = mysqli_error($conexion);
    }
  } else {
    $resultado['error2'] = true;
    $resultado['nom'] = $nomb;
  }
} else
  $resultado['error3'] = true;


echo json_encode($resultado);
