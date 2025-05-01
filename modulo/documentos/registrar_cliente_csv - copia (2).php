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

  $resultado = array();

  $errores = false;

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

    //echo $ident . " " . $nomb . " " . $apell . " " . $tipid . " " . $dire . " " . $tele . " " . $cor;

    // Verificar si algún campo está vacío
    if (empty($ident) || empty($nomb) || empty($apell) || empty($dire) || empty($tele) || empty($cor) || empty($tipid)) {
      $errores = true;
      break;
    }
  }

  /*
    $insertar = "INSERT INTO personas (Identificacion,Nombre,Apellido,Direccion,Telefono,Correo,TipoId,Contrasena) 
    VALUES('$ident','$nomb','$apell','$dire','$tele','$cor','$tipid','$cont')";

    $rs2 = mysqli_query($conexion, $insertar);
  }

     */

     if (!$errores) {
      $nombar = "Archivo de Cliente";
  
      $insetar2 = "INSERT INTO archivos (Nombre,Fecha) 
        VALUES('$nombar',NOW())";
  
      $rs3 = mysqli_query($conexion, $insetar2);
  
      if (mysqli_error($conexion) == "") {
        $resultado['error'] = false;
        $resultado['mensaje'] = 'Se realizó el registro exitosamente.';
      } else {
        $resultado['error'] = true;
        $resultado['mensaje'] = mysqli_error($conexion);
      }
    } else {
      $nombar = "documento_cliente_con_error";
      $errorFile = 'C:/Users/centr/Downloads/errores_importacion.csv'; // Especifica la ruta donde deseas guardar el archivo de errores
      copy($archivo, $errorFile); // Copiar el archivo original
      
      $insetar2 = "INSERT INTO archivos (Nombre,Fecha) 
        VALUES('$nombar',NOW())";
  
      $rs3 = mysqli_query($conexion, $insetar2);
  
      // Devolver el nombre del archivo en la respuesta JSON
      $resultado['descargar'] = true;
      $resultado['mensaje'] = 'Hubo errores durante la importación. Puedes descargar el archivo con los errores.';
      $resultado['archivo_errores'] = $errorFile;
    }
  

  echo json_encode($resultado);
}
