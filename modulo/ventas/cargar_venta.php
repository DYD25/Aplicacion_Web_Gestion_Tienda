<?php
$pagina_actual = $_GET['pagina'];


$NUM_REGISTROS_PAGINA = 10;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;

$busqueda = "SELECT p.Nombre AS Nombre, 
d.Nombre AS Producto, 
FORMAT(d.valorv,0) AS valoru, 
FORMAT(SUM(d.valorv),0) AS valort, 
COUNT(v.ProductoId) AS cantidad,
MAX(d.Fecha) AS fecha,
MAX(v.Id) Id,
MAX(p.Id) per
FROM ventas v
JOIN personas p ON p.Id = v.PersonaId
JOIN productos d ON d.id = v.ProductoId
GROUP BY p.Nombre, d.Nombre, d.valorv
ORDER BY cantidad desc

LIMIT $limite OFFSET $salto";

$busqueda_cantidad = "SELECT  COUNT(DISTINCT p.Nombre, d.nombre) AS cantidad
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos d ON d.id = v.ProductoId";
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

    <th> <i class='fa-solid fa-pen-to-square h'></i> <i class='fa-solid fa-trash h' onclick='eliminartodo()'></i></th>

  </tr>

  <tr class="tr">
    <?php
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[Nombre]</td>";
      echo "<td>$guarda[Producto] </td>";
      echo "<td>$guarda[cantidad]</td>";
      echo "<td>$guarda[valoru]</td>";
      echo "<td>$guarda[valort]</td>";
      echo "<td>$guarda[fecha]</td>";
      #$can = ;
      echo "
     <td>  
      <a href='#' class='modificar' onclick='modificar(" . $guarda['Id'] . ")'> <i class='fa-solid fa-pen-to-square '></i> </a>
      <a href='#' class='eliminar' onclick='eliminar($guarda[per],$guarda[cantidad],\"$guarda[Producto]\")'> <i class='fa-solid fa-trash '></i> </a>
      
     </td>";

      echo "</tr>";

      $num = $num + 1;
    }
    ?>
</table>

<?php include_once("paginacion.php"); ?> 