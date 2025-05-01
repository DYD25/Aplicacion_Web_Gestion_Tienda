<?php

$buscar = "SELECT 
pr.nombre producto,
(SELECT COUNT(*)
 FROM ventas v2
 JOIN productos pr2 ON pr2.Id = v2.ProductoId
 WHERE pr2.nombre = pr.nombre) AS cantidad
FROM ventas v
JOIN productos pr ON pr.Id = v.ProductoId
GROUP BY pr.nombre
ORDER BY cantidad DESC
LIMIT 5";
$resultado = mysqli_query($conexion, $buscar); //la manada la consulta

$respuesta = [];
$r = [];

while ($guarda = mysqli_fetch_assoc($resultado)) {
  $r['nombre']=$guarda['producto'];
  $r['cantidad']=$guarda['cantidad'];
  $respuesta[] = $r;

}

echo json_encode($respuesta);
?>



