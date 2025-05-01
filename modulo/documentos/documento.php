<div id="tabla">
    <div id="contenido-tabla" class="conte">

    </div>

</div>

<!-- ----------------script------------ -->

<script type="text/javascript">
    $("#estoy").html('<form id="fordoc" method="post" enctype="multipart/form-data"> <input type="file" accept=".csv" name="incliente" id="incliente" enty class="incliente  clipro" > </form> <p class="pcli col"><i id="col" class="fa-solid fa-file-arrow-up"></i> CARGAR CLIENTES  </p>');
    $("#nuevo").html(' <form id="forpro" method="post" enctype="multipart/form-data"> <input type="file" accept=".csv" name="inproducto" id="inproducto" enty class=" inproducto clipro" > </form> <p class="ppro col"><i id="col" class="fa-solid fa-file-arrow-up"></i> SUBIR PRODUCTO </p>');

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();

    });

    function cargar_datos(urlDescarga) {
        $("#contenido-tabla").load("?modulo=cargar-documento&pagina=" + pagina + "&archivo_errores=" + encodeURIComponent(urlDescarga));
    }



    $(document).ready(function() {
        // Manejar el cambio en el elemento #inproducto
        $("body").on('change', '#inproducto', function() {
            var formData = new FormData($("#forpro")[0]);

            if ($('#inproducto').val()) {
                // Realizar una solicitud AJAX para registrar clientes CSV
                $.ajax({
                    url: "?modulo=registrar-producto-csv",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        var guardar_respuesta = jQuery.parseJSON(respuesta);
                        if (guardar_respuesta.error) {
                            alert(guardar_respuesta.mensaje); // Mostrar mensaje de error
                        } else {
                            cargar_datos();
                            texto = "Archivo procesado exitosamente";
                            exito(texto);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error al procesar el archivo: " + error); // Mostrar mensaje de error de AJAX
                    }
                });
            } else {
                alert("No se seleccionó ningún archivo");
            }
        });

        $("body").on('change', '#incliente', function() {
            var formData = new FormData($("#fordoc")[0]);

            if ($('#incliente').val()) {
                // Realizar una solicitud AJAX para registrar productos CSV
                $.ajax({
                    url: "?modulo=registrar-cliente-csv",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        var guardar_respuesta = jQuery.parseJSON(respuesta);
                        if (guardar_respuesta.error) {
                            texto = guardar_respuesta.mensaje;
                            alerta(texto);
                        } else if (guardar_respuesta.descargar) {
                            texto = guardar_respuesta.mensaje;
                            alerta(texto);
                            var url = 'ruta/al/archivo/' + guardar_respuesta.archivo_errores; // Corregir aquí
                            cargar_datos(url);
                        } else {
                            cargar_datos();
                            texto = "Archivo procesado exitosamente " + guardar_respuesta.mensaje;
                            exito(texto);
                        }
                    },
                    error: function(xhr, status, error) {
                        texto = "Error al procesar el archivo: " + error;
                        error(texto);
                    }
                });
            } else {
                texto = "No se seleccionó ningún archivo";
                alerta(texto);
            }
        });


        /*   // Manejar el cambio en el elemento #incliente
          $("body").on('change', '#incliente', function() {
              var formData = new FormData($("#fordoc")[0]);

              if ($('#incliente').val()) {
                  // Realizar una solicitud AJAX para registrar productos CSV
                  $.ajax({
                      url: "?modulo=registrar-cliente-csv",
                      type: "POST",
                      data: formData,
                      contentType: false,
                      processData: false,
                      success: function(respuesta) {
                          var guardar_respuesta = jQuery.parseJSON(respuesta);
                          if (guardar_respuesta.error) {
                              texto = guardar_respuesta.mensaje;
                              alerta(texto);
                          } else if (guardar_respuesta.descargar) {
                              texto = guardar_respuesta.mensaje;
                              alerta(texto);
                              var url = 'ruta/al/archivo/' + guardar.archivo_errores;
                              cargar_datos(url);

                          } else {
                              cargar_datos();
                              texto = "Archivo procesado exitosamente " + guardar_respuesta.mensaje;
                              exito(texto);
                          }
                      },
                      error: function(xhr, status, error) {
                          texto = "Error al procesar el archivo: " + error;
                          error(texto);

                      }
                  });
              } else {
                  texto = "No se seleccionó ningún archivo";
                  alerta(texto);

              }
          });;*/
    })

    function eliminar(id) {
        if (confirm("Desea eliminar el registro seleccionado?") == true) {
            var parametros = "id=" + id;
            $.post("?modulo=eliminar-documento", parametros, function(respuesta) {
                var guardar_resp = jQuery.parseJSON(respuesta);
                if (guardar_resp.error == false) {
                    texto = "ha registro ha siod eliminado con un exito";
                    exito(texto);
                    cargar_datos();
                } else {
                    texto = "No se ha podido completar la eliminacion del <br>registro , por un error inesperado... <br> Por favor consulte con el administrador ";
                    error(texto);
                }
            });
        }
    }

    function eliminartodo() {

        if (confirm("¿Desea eliminar todos los registros?") == true) {
            var parametros = 1;
            $.post("?modulo=eliminar-todo-documento", parametros, function(respuesta) {
                var guardar_resp = jQuery.parseJSON(respuesta);
                if (guardar_resp.error == false) {
                    texto = "ha registro ha siod eliminado con un exito";
                    exito(texto);
                    cargar_datos();
                } else {
                    texto = "No se ha podido completar la eliminacion del <br>registro , por un error inesperado... <br> Por favor consulte con el administrador ";
                    error(texto);
                }
            });
        }

    }

    function ir_a_pagina(p) {
        pagina = p;
        cargar_datos();
    }
</script>