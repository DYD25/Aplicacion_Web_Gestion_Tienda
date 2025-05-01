<?php
global $conexion;

$perId = $_POST['idper'];

$code = $_POST['code'];
$des = $_POST['des'];
$nomb = $_POST['nom'];
$valc = $_POST['valc'];
$valv = $_POST['valv'];
$est = $_POST['est'];


$resultado = [];
if (!empty($code) && !empty($des) && !empty($nomb) && !empty($valc) && !empty($valv) && !empty($est)) {

	$busqueda = "select * from productos where Id  = '$perId'";
	$consulta = mysqli_query($conexion, $busqueda);
	$rw = mysqli_fetch_array($consulta);

	if ($des != $rw['Descripcion'] || $code != $rw['Codigo'] || $rw['Nombre'] != $nomb || $rw['ValorC'] != $valc || $rw['ValorV'] != $valv || $rw['EstadoId'] != $est) {

		$actualizar = "UPDATE productos SET  
			Descripcion ='$des',Nombre ='$nomb',ValorC = '$valc',ValorV = '$valv',Codigo ='$code', EstadoId ='$est'
			WHERE Id = '$perId'";

		mysqli_query($conexion, $actualizar);

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
} else {
	$resultado['error3'] = true;
}

echo json_encode($resultado);
