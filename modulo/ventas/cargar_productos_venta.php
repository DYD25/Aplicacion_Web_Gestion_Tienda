<?php
$buscar = " SELECT Id, Nombre, FORMAT(ValorV, 0) Precio, COUNT(*) AS cantidad 
FROM productos
WHERE EstadoId = '1' AND Nombre 
IN (SELECT Nombre FROM productos GROUP BY Nombre HAVING COUNT(*) = 1)
GROUP BY Id, Nombre, Precio UNION ALL
SELECT MIN(Id) AS id_producto, Nombre, FORMAT(ValorV, 0) Precio, COUNT(*) AS cantidad
FROM productos
WHERE EstadoId = '1' AND Nombre IN (
SELECT Nombre
FROM productos
GROUP BY Nombre
HAVING COUNT(*) > 1
)
GROUP BY Nombre, Precio 
order by Nombre";
$resultado = mysqli_query($conexion, $buscar); //la manada la consulta

$respuesta = [];
while ($guarda = mysqli_fetch_assoc($resultado)) {
    $r = [];
    $r['valor'] = $guarda['Id'];
    $r['texto'] = "Nombre: $guarda[Nombre] - Precio: $guarda[Precio] - Dispon: $guarda[cantidad]";
    $respuesta[] = $r;
}

echo json_encode($respuesta);
