<?php
global $conexion;

$tipid = $_POST['tip'];
$ident = $_POST['iden'];
$nomb = $_POST['nom'];
$apell = $_POST['ape'];
$dire = $_POST['dir'];
$tele = $_POST['tel'];
$cor = $_POST['cor'];
$cont = $_POST['cont'];
// || isset($ident)|| isset($nomb)|| isset($apell) || isset($dire) || isset($tele) || isset($cor)
$resultado = [];
if (!empty($tipid) && !empty($ident) && !empty($nomb) && !empty($apell) && !empty($dire) && !empty($tele) && !empty($cor)) {

  $busqueda = "select * from personas where Identificacion = '$ident'";
  $consulta = mysqli_query($conexion, $busqueda);
  $rw = mysqli_fetch_array($consulta);

  if (empty($rw)) {

    $insetar = "INSERT INTO personas (Identificacion,Nombre,Apellido,Direccion,Telefono,Correo,TipoId,Contrasena) 
    VALUES('$ident','$nomb','$apell','$dire','$tele','$cor','$tipid','$cont')";

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
