<?php
require_once("conexion.php");


if (isset($_GET['modulo'])) {
  $contenido = $_GET['modulo'];
} else {
  $contenido = "inicio";
}



$modulos = [

  //-----------SISTEMA-----________
  "inicio" => [
    "diseño" => "login",
    "archivo" => "login.php"
  ],

  // --------------------sesion-----------------

  "sesion-verificar" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/sesion/verificar_sesion.php"
  ],

  "sesion-cerrar-sesion" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/sesion/cerrar_sesion.php"
  ],


  // --------------------
  "tienda" => [
    "diseño" => "sistema",
    "archivo" => "modulo/tienda/inicio.php"
  ],

  "cargar-consolidado-inicio" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/tienda/cargar_consolidado_ini.php"

  ],
  "cargar-venta-mejor" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/tienda/cargar_mejor_ventain.php"
  ],
 

  // ------------persona-------------
  "persona" => [
    "diseño" => "sistema",
    "archivo" => "modulo/personas/persona_formulario.php"
  ],

  "persona-cargar-datos" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/personas/cargar_datos.php"
  ],

  "persona-registrar" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/personas/registrar_datos.php"
  ],

  "persona-eliminar-datos" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/personas/eliminar_datos.php"
  ],

  "persona-consulta-datos" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/personas/consultar_datos.php"
  ],

  "persona-actualizar-datos" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/personas/actualizar_datos.php"
  ],

  // ------------producto-------------
  "producto" => [
    "diseño" => "sistema",
    "archivo" => "modulo/productos/producto.php"
  ],

  "cargar-producto" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/productos/cargar_producto.php"
  ],

  "registrar-producto" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/productos/registrar_producto.php"
  ],
"eliminar-producto" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/productos/eliminar_producto.php"
  ],
  

  "consulta-producto" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/productos/consultar_producto.php"
  ],

  "actualizar-producto" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/productos/actualizar_producto.php"
  ],
  "eliminar-todo-producto" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/productos/eliminar_todo_producto.php"
  ],

  // ------------venta-------------
  "venta" => [
    "diseño" => "sistema",
    "archivo" => "modulo/ventas/venta.php"
  ],

  "cargar-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/cargar_venta.php"
  ],

  "consulta-reg-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/consulta_reg_venta.php"
  ],

  "registrar-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/registrar_venta.php"
  ],

  "eliminar-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/eliminar_venta.php"
  ],

  "consulta-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/consultar_venta.php"
  ],

  "cargar-productos-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/cargar_productos_venta.php"
  ],
  "actualizar-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/actualizar_venta.php"
  ],
  "eliminar-todo-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/ventas/eliminar_todo_venta.php"
  ],

  // ----------detalle ------
  "detalle-cliente" => [
    "diseño" => "sistema",
    "archivo" => "modulo/detalles/detalle_cliente.php"
  ],
  "cargar-detalle-cliente" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/detalles/cargar_detalle_cliente.php"
  ],

  "ver-detalle-cliente" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/detalles/ver_detalle_cliente.php"
  ],

  "consolidado-compras" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/detalles/consolidado_compras.php"
  ],
  // ----------mejores venta ------
  "mejores-venta" => [
    "diseño" => "sistema",
    "archivo" => "modulo/mejores/mejor_venta.php"
  ],
  "cargar-mejor-venta" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/mejores/cargar_mejor_venta.php"
  ],

  // ----------documentos ------
  "documento" => [
    "diseño" => "sistema",
    "archivo" => "modulo/documentos/documento.php"
  ],
  "cargar-documento" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/documentos/cargar_documento.php"
  ],

  "registrar-cliente-csv" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/documentos/registrar_cliente_csv.php"
  ],
  "registrar-producto-csv" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/documentos/registrar_productos_csv.php"
  ],
  "eliminar-documento" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/documentos/eliminar_documento.php"
  ],
  "eliminar-todo-documento" => [
    "diseño" => "diseno_libre",
    "archivo" => "modulo/documentos/eliminar_todo_documento.php"
  ],

];

if (isset($modulos[$contenido])) {
  $diseno = $modulos[$contenido]["diseño"];
  $archivo = $modulos[$contenido]["archivo"];
} else {
  require_once("error.php");
}


/*

*/
