<?php
$busqueda = "SELECT 
pr.nombre producto,
FORMAT(SUM(pr.ValorV),0) AS valort,
MAX(v.Fecha) AS fecha,
(SELECT COUNT(*)
 FROM ventas v2
 JOIN productos pr2 ON pr2.Id = v2.ProductoId
 WHERE pr2.nombre = pr.nombre) AS cantidad
FROM ventas v
JOIN productos pr ON pr.Id = v.ProductoId
GROUP BY pr.nombre
ORDER BY CAST(REPLACE(FORMAT(SUM(pr.ValorV), 0), ',', '') AS DECIMAL) desc
LIMIT 5";


$consulta = mysqli_query($conexion, $busqueda);

?>
<table class="table" id="customers">

  <tr class="tr">
    <th>No.</th>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Valor Total </th>
    <th>Fecha</th>


  </tr>

  <tr class="tr">
    <?php
    $num=1;
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[producto] </td>";
      echo "<td>$guarda[cantidad]</td>";
      echo "<td>$guarda[valort]</td>";
      echo "<td>$guarda[fecha]</td>";
   
      echo "</tr>";

      $num = $num + 1;
    }
    ?>
</table>

