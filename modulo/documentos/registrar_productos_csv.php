<?php
require __DIR__ . '/../../vendor/autoload.php';

global $conexion;

$resultado = array();
$archivo = $_FILES['inproducto']['tmp_name'];


if (!empty($_FILES['inproducto']['name'])) {

  if ($_FILES['inproducto']['type'] == 'text/csv') {
    $archivo = $_FILES['inproducto']['tmp_name'];
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

  $nombar = "Archivo de producto";

  $documento = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo);
  $hoja = $documento->getActiveSheet();
  $filas = $hoja->getHighestDataRow();

  for ($fi = 2; $fi <= $filas; $fi++) {
    $cod = $hoja->getCell('A' . $fi)->getValue();
    $nomb = $hoja->getCell('B' . $fi)->getValue();
    $des = $hoja->getCell('C' . $fi)->getValue();
    $valv = $hoja->getCell('D' . $fi)->getValue();
    $valc = $hoja->getCell('E' . $fi)->getValue();


    $insertar = "INSERT INTO productos (Codigo,Nombre,Descripcion,ValorV,ValorC,EstadoId,Fecha) 
    VALUES('$cod','$nomb','$des','$valv','$valc','1',NOW())";

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
