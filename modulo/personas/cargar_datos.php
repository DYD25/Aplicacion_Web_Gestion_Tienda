<?php
$pagina_actual = $_GET['pagina'];


$NUM_REGISTROS_PAGINA = 16;
$salto = ($pagina_actual - 1) * $NUM_REGISTROS_PAGINA;
$limite = $NUM_REGISTROS_PAGINA;

$busqueda = "SELECT 
p.Nombre nom,
p.Apellido ape,
p.Direccion dir,
p.Identificacion iden,
p.Id Id,
p.Correo cor,
p.Telefono tel,
t.Nombre tid,
t.Abre des

FROM  personas p
join tipo_documento t on t.Id =p.TipoId
  LIMIT $limite OFFSET $salto";

$busqueda_cantidad = "SELECT COUNT(*) as cantidad FROM personas";
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
    <th>Identidad</th>
    <th>Nom.completo</th>
    <th>Dirección</th>
    <th>Teléfono</th>
    <th>Correo</th>
    <th> <i class='fa-solid fa-pen-to-square h'></i> <i class='fa-solid fa-trash h'></i></th>

  </tr>

  <tr class="tr">
    <?php
    while ($guarda = mysqli_fetch_assoc($consulta)) {
      echo "<td>$num</td>";
      echo "<td>$guarda[des]:$guarda[iden]</td>";
      echo "<td>$guarda[nom] $guarda[ape] </td>";
      echo "<td>$guarda[dir]</td>";
      echo "<td>$guarda[tel]</td>";
      echo "<td>$guarda[cor]</td>";
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