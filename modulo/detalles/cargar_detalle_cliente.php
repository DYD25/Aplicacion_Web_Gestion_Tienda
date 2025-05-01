<?php
$pagina_actual = $_GET['pagina'];


$NUM_REGISTROS_PAGINA = 15;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;

$busqueda = "SELECT 
CONCAT(td.Abre,' ', p.Nombre, ' ', p.Apellido) AS persona, FORMAT(SUM(pr.ValorV),0) AS valort,
max(v.Fecha) fecha,COUNT(v.ProductoId)cantidad,Min(pr.Nombre) producto, MAX(p.Id) id
FROM ventas v
JOIN personas p ON v.PersonaId = p.Id
JOIN productos pr ON pr.Id = v.ProductoId
JOIN tipo_documento td ON td.Id = p.TipoId
WHERE p.Nombre != 'futuro'
GROUP BY CONCAT(td.Abre, ' ', p.Nombre, ' ', p.Apellido)
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
    <th>Productos</th>
    <th>Cantidad</th>
    <th>Valor Total </th>
    <th>Fecha</th>

    <th><i class="fa-solid fa-eye"></i></th>

  </tr>

  <tr class="tr">
    <?php
    while ($guarda = mysqli_fetch_assoc($consulta)) {



      echo "<td>$num</td>";
      echo "<td>$guarda[persona]</td>";
      echo "<td>$guarda[producto].... </td>";
      echo "<td>$guarda[cantidad]</td>";
      echo "<td>$guarda[valort]</td>";
      echo "<td>$guarda[fecha]</td>";
      #$can = ;
      echo "
     <td>  
      <a href='#' class='modificar' onclick='ver(" . $guarda['id']. ")'> <i class='fa-solid fa-eye'></i> </a>
      
     </td>";

      echo "</tr>";

      $num = $num + 1;
     
    }
    ?>
</table>

<?php include_once("paginacion.php"); ?>