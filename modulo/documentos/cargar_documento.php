<?php
$pagina_actual = $_GET['pagina'];
$archivo_errores = isset($_GET['archivo_errores']) ? $_GET['archivo_errores'] : null; // Obtener la ruta del archivo de errores, si está presente

$NUM_REGISTROS_PAGINA = 10;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;
$busqueda = "SELECT * from archivos LIMIT $limite OFFSET $salto";

$consulta = mysqli_query($conexion, $busqueda);
$busqueda_cantidad = "SELECT count(*) cantidad from archivos ";
$consultar_cantidad = mysqli_query($conexion, $busqueda_cantidad);
if ($guardar_cantidad = mysqli_fetch_assoc($consultar_cantidad)) {
  $cantidad = $guardar_cantidad['cantidad'];
  $num_paginas = ceil($cantidad / $NUM_REGISTROS_PAGINA);
}
?>
<table class="table" id="customers">
  <tr class="tr">
    <th>No.</th>
    <th>Nombre Archivo</th>
    <th>Fecha</th>
    <th><i class='fa-solid fa-file-arrow-down'> <i class='fa-solid fa-trash' onclick='eliminartodo()'></i> </th>
  </tr>
  <tr class="tr">
    <?php
    $num = $salto + 1;
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[Nombre] </td>";
      echo "<td>$guarda[Fecha]</td>";
      echo "<td>"; // Abrir la celda donde irá el enlace de descarga
      if ($archivo_errores) { // Si hay un archivo de errores, mostrar el enlace
        echo "<a href='$archivo_errores' download> <i class='fa-solid fa-file-arrow-down'></i></a>";
      }
      echo "<a href='#' class='eliminar' onclick='eliminar($guarda[Id])'> <i class='fa-solid fa-trash '></i> </a>";

      echo "</td>"; // Cerrar la celda
      echo "</tr>";
      $num = $num + 1;
    }
    ?>
</table>
<?php include_once("paginacion.php"); ?>