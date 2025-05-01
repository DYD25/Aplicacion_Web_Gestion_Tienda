<?php
$pagina_actual = $_GET['pagina'];
$iden = $_GET['iden'];

$NUM_REGISTROS_PAGINA = 2;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;

$busqueda = "SELECT 
CONCAT(td.Abre,' ', p.Nombre, ' ', p.Apellido) AS persona,  
FORMAT(SUM(pr.ValorV), 0) AS valort,
MAX(v.Fecha) AS fecha,
FORMAT(MAX(pr.valorv),0) valoru,
COUNT(v.ProductoId) AS cantidad,
pr.Nombre AS producto
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos pr ON pr.Id = v.ProductoId
JOIN tipo_documento td ON td.Id = p.TipoId
WHERE p.Nombre != 'futuro' AND p.id = '$iden'
GROUP BY  pr.Nombre
ORDER BY CAST(REPLACE(FORMAT(SUM(pr.ValorV), 0), ',', '') AS DECIMAL) desc

LIMIT $limite OFFSET $salto";

$busqueda_cantidad = "SELECT COUNT(DISTINCT pr.Nombre) AS cantidad
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos pr ON pr.Id = v.ProductoId

WHERE 
p.Nombre != 'futuro' AND p.id='$iden'";
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
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Valor Unitario </th>
    <th>Valor Total </th>
    <th>Fecha</th>

    <th> <a href='' class='modificar'><i class='fa-solid fa-eye-low-vision'> </i> </a></th>

  </tr>

  <tr class="tr">
    <?php
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[persona]</td>";
      echo "<td>$guarda[producto] </td>";
      echo "<td>$guarda[cantidad]</td>";
      echo "<td>$guarda[valoru]</td>";
      echo "<td>$guarda[valort]</td>";
      echo "<td>$guarda[fecha]</td>";
      #$can = ;
      echo "
     <td>  
     <a href='' class='modificar' ><i class='fa-solid fa-eye-low-vision'> </i> </a>

     </td>";

      echo "</tr>";

      $num = $num + 1;
    }
    ?>
</table>

<?php include_once("paginacion.php"); ?>