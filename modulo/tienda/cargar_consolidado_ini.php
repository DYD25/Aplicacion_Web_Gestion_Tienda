<?php
$buscar = "SELECT 
p.Nombre AS persona, SUM(pr.ValorV) AS valort
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos pr ON pr.Id = v.ProductoId
WHERE p.Nombre != 'Futuro Cliente'
GROUP BY p.Nombre
LIMIT 5";
$resultado = mysqli_query($conexion, $buscar); //la manada la consulta

$respuesta = [];
$r = [];

while ($guarda = mysqli_fetch_assoc($resultado)) {
  $r['nombre']=$guarda['persona'];
  $r['valor']=$guarda['valort'];
  $respuesta[] = $r;

}

echo json_encode($respuesta);