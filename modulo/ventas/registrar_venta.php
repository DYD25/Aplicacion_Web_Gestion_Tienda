<?php
global $conexion;

$pro = $_POST['pro'];
$nomb = $_POST['per'];
$can = $_POST['can'];
$val = $_POST['val'];
$resultado = [];


if (empty($nomb)) {
  $busqueda = "SELECT * FROM personas WHERE Nombre = 'Futuro'";
  $consulta = mysqli_query($conexion, $busqueda);
  $rw = mysqli_fetch_array($consulta);

  if (!$rw) {
    $insetar = "INSERT INTO personas (Identificacion,Nombre,Apellido,Direccion,Telefono,Correo,TipoId,Contrasena) 
    VALUES('$2024','Futuro','Cliente','OTRO','OTRO','NO@APLI.CA','3','$$44$$')";
    $rs2 = mysqli_query($conexion, $insetar);
    mysqli_error($conexion);

    $busqueda3 = "SELECT * FROM personas WHERE Nombre = 'Futuro'";
    $consulta3 = mysqli_query($conexion, $busqueda3);
    $rw3 = mysqli_fetch_array($consulta3);
    $nomb = $rw3['Id'];
  } else {
    $nomb = $rw['Id'];
  }
}

if (!empty($val) && !empty($can)) {


  $busqueda2 = "SELECT * FROM productos
  WHERE Id='$pro'";
  $consulta2 = mysqli_query($conexion, $busqueda2);
  $rw2 = mysqli_fetch_array($consulta2);


  $nomp = $rw2['Nombre'];

  $insetar = "INSERT INTO ventas (ProductoId, PersonaId, Fecha)
  SELECT p.Id, '$nomb', NOW()
  FROM (
      SELECT 
          Id, 
          ROW_NUMBER() OVER (PARTITION BY Nombre ORDER BY Id) AS row_num
      FROM productos
      WHERE Nombre = '$nomp'
  ) AS productos_repetidos
  JOIN productos AS p ON p.Id = productos_repetidos.Id
  WHERE row_num <= '$can'";

  mysqli_query($conexion, $insetar);

  if (mysqli_error($conexion) == "") {
    $actualizar = "UPDATE productos
    SET EstadoId = 2
    WHERE Id IN (
        SELECT Id FROM (
            SELECT p.Id
            FROM (
                SELECT 
                    Id, 
                    ROW_NUMBER() OVER (PARTITION BY Nombre ORDER BY Id) AS row_num
                FROM productos
                WHERE Nombre = '$nomp'
            ) AS productos_repetidos
            JOIN productos AS p ON p.Id = productos_repetidos.Id
            WHERE row_num <= '$can'
        ) AS subquery
    )";


    mysqli_query($conexion, $actualizar);
    if (mysqli_error($conexion) == "") {
      $resultado['error'] = false;
    } else {
      $resultado['error'] = true;
      $resultado['mensaje'] = mysqli_error($conexion);
    }
  } else {
    $resultado['error'] = true;
    $resultado['mensaje'] = mysqli_error($conexion);
  }
} else {
  $resultado['error3'] = true;
}

echo json_encode($resultado);
