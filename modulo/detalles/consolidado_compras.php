<?php
$pagina_actual = $_GET['pagina'];

$NUM_REGISTROS_PAGINA = 10;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;

$busqueda = " SELECT 
CONCAT(td.Abre, ': ', p.Nombre, ' ', p.Apellido) AS persona, 
FORMAT(SUM(pr.ValorV),0) AS valort,
Max(v.Fecha) fecha
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos pr ON pr.Id = v.ProductoId
JOIN tipo_documento td ON td.Id = p.TipoId
WHERE p.Nombre != 'Futuro Cliente'
GROUP BY CONCAT(td.Abre, ': ', p.Nombre, ' ', p.Apellido)
ORDER BY CAST(REPLACE(FORMAT(SUM(pr.ValorV), 0), ',', '') AS DECIMAL) desc

LIMIT $limite OFFSET $salto";

$busqueda_cantidad = "SELECT 
COUNT(DISTINCT CONCAT(td.Abre, ': ', p.Nombre, ' ', p.Apellido)) AS cantidad
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos pr ON pr.Id = v.ProductoId
JOIN tipo_documento td ON td.Id = p.TipoId
WHERE p.Nombre != 'futuro'";
$consultar_cantidad = mysqli_query($conexion, $busqueda_cantidad);
if ($guardar_cantidad = mysqli_fetch_assoc($consultar_cantidad)) {
  $cantidad = $guardar_cantidad['cantidad'];
  $num_paginas = ceil($cantidad / $NUM_REGISTROS_PAGINA);
}

$consulta = mysqli_query($conexion, $busqueda);
$num = $salto + 1;

?>
<table class="table" id="customers">

  <tr class="tr">
    <th>No.</th>
    <th>Nombre Cliente</th>
    <th>Valor Total </th>
    <th>Fecha</th>

  </tr>

  <tr class="tr">
    <?php
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[persona]</td>";
      echo "<td>$guarda[valort]</td>";
      echo "<td>$guarda[fecha]</td>";
      echo "</tr>";

      $num = $num + 1;
    }
    ?>
</table>

<?php include_once("paginacion.php"); ?>