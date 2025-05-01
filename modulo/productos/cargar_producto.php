<?php

$pagina_actual = $_GET['pagina'];

$NUM_REGISTROS_PAGINA = 10;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;

$busqueda = "SELECT 
Nombre AS nomb,FORMAT(SUM(ValorC), 0) AS val,FORMAT(SUM(ValorV),0) AS valo,
SUM(CASE WHEN EstadoId = 1 THEN 1 ELSE 0 END) AS disponible,
COUNT(nombre) cantidad,
MAX(Fecha) AS fecha,MAX(Id) AS Id
FROM  productos 
GROUP BY Nombre
ORDER BY nomb asc

LIMIT $limite OFFSET $salto";

$busqueda_cantidad = "SELECT 
EstadoId,COUNT(DISTINCT Nombre) AS cantidad
FROM productos WHERE EstadoId =1 GROUP BY EstadoId";
$consultar_cantidad = mysqli_query($conexion, $busqueda_cantidad);
if ($guardar_cantidad = mysqli_fetch_assoc($consultar_cantidad)) {
  $cantidad = $guardar_cantidad['cantidad'];
  $num_paginas = ceil($cantidad / $NUM_REGISTROS_PAGINA);
}

$consulta = mysqli_query($conexion, $busqueda);
$num = $salto + 1;

?>
<table class="table" id="customers">

  <tr class="tr trf">
    <th>No.</th>
    <th>Nombre</th>
    <th>Cantidad</th>
    <th>Val. Total Compra</th>
    <th>Val. Total Venta</th>
    <th>Disponible</th>
    <th>Fecha</th>
    <th> <i class='fa-solid fa-pen-to-square h'></i> <i class='fa-solid fa-trash h' onclick='eliminartodo()'></i></th>

  </tr>

  <tr class="tr">
    <?php
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[nomb]</td>";
      echo "<td>$guarda[cantidad]</td>";
      echo "<td>$guarda[val]</td>";
      echo "<td>$guarda[valo]</td>";
      echo "<td>$guarda[disponible]</td>";
      echo "<td>$guarda[fecha]</td>";

      echo "
     <td>  
      <a href='#' class='modificar' onclick='modificar($guarda[Id])'> <i class='fa-solid fa-pen-to-square '></i> </a> 
      <a href='#' class='eliminar' onclick='eliminar($guarda[Id])'> <i class='fa-solid fa-trash '></i> </a>
     </td>";

      echo "</tr>";

      $num = $num + 1;
    }
    ?>
</table>

<?php include_once("paginacion.php"); ?>