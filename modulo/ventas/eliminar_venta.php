<?php
global $conexion;

$id = $_POST['id'];
$can = $_POST['can'];
$nompro = $_POST['nompro'];


$cant = 0;
$resultado = [];

do {
    $busqueda = "SELECT *
    FROM ventas v
    JOIN productos p ON p.id= v.ProductoId
    WHERE v.PersonaId = '$id' AND p.Nombre = '$nompro'";

    $consulta = mysqli_query($conexion, $busqueda);
    $rw = mysqli_fetch_array($consulta);

    $pro = $rw['ProductoId'];

    $eliminar = "DELETE FROM ventas WHERE PersonaId='$id' and ProductoId ='$pro'";

    mysqli_query($conexion, $eliminar);

    if (mysqli_error($conexion) == "") {
        $actualizar = "UPDATE productos SET  
			EstadoId ='1'
			WHERE Id = '$pro'";
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

    $cant = $cant + 1;
} while ($cant < $can);

echo json_encode($resultado);
