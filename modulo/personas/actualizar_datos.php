<?php
global $conexion;

$perId = $_POST['idper'];

$tipid = $_POST['tip'];
$ident = $_POST['iden'];
$nomb = $_POST['nom'];
$apell = $_POST['ape'];
$dire = $_POST['dir'];
$tele = $_POST['tel'];
$cor = $_POST['cor'];
$cont = $_POST['cont'];

$resultado = [];
if (!empty($tipid) && !empty($ident) && !empty($nomb) && !empty($apell) && !empty($dire) && !empty($tele) && !empty($cor)) {

	$busqueda = "select * from personas where Id  = '$perId'";
	$consulta = mysqli_query($conexion, $busqueda);
	$rw = mysqli_fetch_array($consulta);

	$busqueda2 = "select * from personas where Identificacion  = '$ident'";
	$consulta2 = mysqli_query($conexion, $busqueda2);
	$rw2 = mysqli_fetch_array($consulta2);

	#if ($rw2 == "") {

	if ($ident != $rw['Identificacion'] || $tipid != $rw['TipoId'] || $rw['Nombre'] != $nomb || $rw['Apellido'] != $apell || $rw['Direccion'] != $dire || $rw['Telefono'] != $tele || $rw['Correo'] != $cor || $cont == true) {

		$actualizar = "UPDATE personas SET  
			Identificacion ='$ident',Nombre ='$nomb',Apellido = '$apell',
			Direccion= '$dire',Telefono= '$tele',Correo= '$cor',TipoId ='$tipid', Contrasena = '$cont'
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
	// } else {
	// 	$resultado['error4'] = true;
	// 	$resultado['nom'] = $nomb . " " . $apell;
	// 	$resultado['nom2'] = $rw2['Nombre'] . " " . $rw2['Apellido'];
	// }
} else {
	$resultado['error3'] = true;
}

echo json_encode($resultado);
