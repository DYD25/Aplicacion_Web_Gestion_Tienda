<?php
global $conexion;

$perId = $_POST['idper'];
$nompro = $_POST['nomprod'];
$nompers = $_POST['nompers'];

$produ = $_POST['pro'];
$nomb = $_POST['per'];
$can = $_POST['can'];
$cant = 0;

if (!empty($can)) {

	$busqueda = "SELECT * 
	from ventas 
	where Id  = '$perId'";

	$consulta = mysqli_query($conexion, $busqueda);
	$rw = mysqli_fetch_array($consulta);


	if ($produ != $rw['ProductoId']  || $nomb !=  $rw['PersonaId'] || $can == true) {

		do {
			$busqueda = "SELECT *
			FROM ventas v
			JOIN productos p ON p.id= v.ProductoId
			WHERE v.PersonaId = '$nompers' AND p.Nombre = '$nompro'";

			$consulta = mysqli_query($conexion, $busqueda);
			if($rw = mysqli_fetch_array($consulta)){

				$pro = $rw['ProductoId'];
			}else{
				$pro = $produ;

			}

			$eliminar = "DELETE FROM ventas WHERE PersonaId='$nompers' and ProductoId ='$pro'";

			mysqli_query($conexion, $eliminar);

			if (mysqli_error($conexion) == "") {
				$actualizar = "UPDATE productos SET  
					EstadoId ='1'
					WHERE Id = '$pro'";
				mysqli_query($conexion, $actualizar);
				if (mysqli_error($conexion) == "") {

					$insetar = "INSERT INTO ventas (ProductoId,PersonaId,Fecha) 
					VALUES('$produ','$nomb',NOW())";

					$rs2 = mysqli_query($conexion, $insetar);
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
				$resultado['error'] = true;
				$resultado['mensaje'] = mysqli_error($conexion);
			}

			$cant = $cant + 1;
		} while ($cant < $can);
	} else {
		$resultado['error2'] = true;
		$resultado['nom'] = $nomb;
	}
} else {
	$resultado['error3'] = true;
}


echo json_encode($resultado);
