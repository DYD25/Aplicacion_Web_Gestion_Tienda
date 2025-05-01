<?php
require __DIR__ . '/../../vendor/autoload.php';

global $conexion;

$resultado = array();
$archivo = $_FILES['incliente']['tmp_name'];


if (!empty($_FILES['incliente']['name'])) {

  if ($_FILES['incliente']['type'] == 'text/csv') {
    $archivo = $_FILES['incliente']['tmp_name'];
    ImportarDatos($archivo);
  } else {
    $resultado['error'] = true;
    $resultado['mensaje'] = "El tipo de archivo no es CSV";
  }
} else {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'No se seleccionó ningún archivo';
}


function ImportarDatos($archivo)
{
  global $conexion;

  $nombar = "Archivo de Cliente";

  $documento = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo);
  $hoja = $documento->getActiveSheet();
  $filas = $hoja->getHighestDataRow();

  for ($fi = 2; $fi <= $filas; $fi++) {
    $ident = $hoja->getCell('A' . $fi)->getValue();
    $nomb = $hoja->getCell('B' . $fi)->getValue();
    $apell = $hoja->getCell('C' . $fi)->getValue();
    $dire = $hoja->getCell('D' . $fi)->getValue();
    $tele = $hoja->getCell('E' . $fi)->getValue();
    $cor = $hoja->getCell('F' . $fi)->getValue();
    $tipid = $hoja->getCell('G' . $fi)->getValue();
    $cont = ($fi++ . "$3%5$" . ($fi * 2) . "%%");


    $insertar = "INSERT INTO personas (Identificacion,Nombre,Apellido,Direccion,Telefono,Correo,TipoId,Contrasena) 
    VALUES('$ident','$nomb','$apell','$dire','$tele','$cor','$tipid','$cont')";

    $rs2 = mysqli_query($conexion, $insertar);
  }

  if ($rs2) {
    $insetar2 = "INSERT INTO archivos (Nombre,Fecha) 
    VALUES('$nombar',NOW())";

    $rs3 = mysqli_query($conexion, $insetar2);

    if (mysqli_error($conexion) == "") {

      $resultado['error'] = false;
    } else {
      $resultado['error'] = true;
      $resultado['mensaje'] = mysqli_error($conexion);
    }
    $resultado['error'] = false;
    $resultado['mensaje'] = 'se realizo el registr';
  } else {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se seleccionó ningún archivo';
  }
}

echo json_encode($resultado);
