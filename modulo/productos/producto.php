<div id="tabla">

    <div id="contenido-tabla" class="conte">

    </div>

    <div id="clientediv">
        <form id="clienteform" method="post">
            <input type="hidden" id="idper" name="idper" />

            <div class="group">
                <div class="input-group">
                    <input type="text" id="code" name="code" class="input" required>
                    <label class="label">Codígo barra</label>
                </div>
                <div class="input-group">
                    <input type="text" id="nom" name="nom" class="input" required>
                    <label class="label">Nombre del producto</label>
                </div>

            </div>

            <div class="group">
                <div class="input-group">
                    <input type="text" id="des" name="des" class="input" required>
                    <label class="label">Descripción</label>
                </div>
                <div class="input-group">
                    <input type="number" id="valc" name="valc" class="input" required>
                    <label class="label">Valor de compra</label>
                </div>
            </div>
            <div class="group">
                <div class="input-group">
                    <input type="number" id="valv" name="valv" class="input" required>
                    <label class="label">Valor de venta</label>
                </div>
                <div class="input-group">
                    <select name="est" id="est" class="input">
                        <?php
                        $buscar = "select * from estado";
                        $resultado = mysqli_query($conexion, $buscar); //la manada la consulta
                        while ($guarda = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='$guarda[Id]'> $guarda[Nombre] </option>'"; //genera un option automatico
                        }
                        ?>
                    </select>
                    <label class="label">Estado del producto</label>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ----------------script------------ -->

<script type="text/javascript">
    $("#estoy").html("<i class='fa-solid fa-cart-shopping'></i>  PRODUCTOS");
    $("#nuevo").html("<a href='#' id='nue_clie'> <i id='col' class='fa-solid fa-cart-shopping'></i> CREAR NUEVO PRODUCTO</a>");

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();
        $("#clienteform").hide();
    });

    function cargar_datos() {
        $("#contenido-tabla").load("?modulo=cargar-producto&pagina=" + pagina);
    }

    $('#nue_clie').click(function() {
        $("#contenido-tabla").hide();
        $("#nue_clie").hide();
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-cart-shopping'></i></a> <span>REGISTRAR PRODUCTO</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="registrar()" class="guardar" id="gua_cli"> Guardar </button>');

        $("#clienteform").show();

    });

    function registrar() {

        var parametros = $("#clienteform").serialize();

        $.post("?modulo=registrar-producto", parametros, function(respuesta) {
            var guardar_respuesta = jQuery.parseJSON(respuesta);

            if (guardar_respuesta.error == false) {
                $("#estoy").html("<i class='fa-solid fa-users'></i> <span> PRODUCTO</span>");
                $("#clienteform").hide();
                $("#contenido-tabla").show();
                $("#nue_clie").show();
                cargar_datos();
                texto = "Se ha registrado con exito ";
                exito(texto);
                $("#clienteform").get(0).reset();
                $("#acciones").html("");

            } else if (guardar_respuesta.error2 == true) {
                texto = "El producto " + guardar_respuesta.nom + " ya se encuentra registrada";
                event.preventDefault();
                alerta(texto);
            } else if (guardar_respuesta.error3 == true) {
                texto = "Verifique por favor que todos los campos estén diligenciados";
                event.preventDefault();
                alerta(texto);
            } else {
                texto = "No se ha podido completar la solicitud de <br>registro , por un error inesperado... <br> Por favor consulte con el administrador ";
                event.preventDefault();
                error(texto);
            }
        });
    }

    function modificar(id) {
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-cart-shopping'></i></a> <span>ACTUALIZAR PRODUCTO</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="actualizar()" class="guardar" "> Actualizar </button>');
        $("#contenido-tabla").hide();
        $("#clienteform").show();
        $("#nue_clie").hide();

        var parametros = "id=" + id;
        $.get("?modulo=consulta-producto", parametros, function(respuesta) {
            var guarda = jQuery.parseJSON(respuesta);

            $("#idper").val(guarda.Id);
            $("#code").val(guarda.Codigo);
            $("#nom").val(guarda.Nombre);
            $("#des").val(guarda.Descripcion);
            $("#valc").val(guarda.ValorC);
            $("#valv").val(guarda.ValorV);
            $("#est").val(guarda.EstadoId);

        });
    }

    function actualizar() {

        if (confirm("¿Realmente desea actualizar el registro seleccionado?") == true) {
            var parametros = $("#clienteform").serialize();

            $.post("?modulo=actualizar-producto", parametros, function(respuesta) {

                var guardar_respuesta = jQuery.parseJSON(respuesta);

                if (guardar_respuesta.error == false) {
                    $("#estoy").html("<i class='fa-solid fa-users'></i> <span> PRODUCTO</span>");
                    $("#clienteform").hide();
                    $("#contenido-tabla").show();
                    $("#nue_clie").show();
                    cargar_datos();
                    texto = "Se ha actualizado con exito ";
                    exito(texto);
                    $("#clienteform").get(0).reset();
                    $("#acciones").html("");

                } else if (guardar_respuesta.error2 == true) {
                    texto = "El producto " + guardar_respuesta.nom + " ya se encuentra registrada <br y no ha realizado ningun cambio";
                    event.preventDefault();
                    alerta(texto);
                } else if (guardar_respuesta.error3 == true) {
                    texto = "Verifique por favor que todos los campos estén diligenciados";
                    event.preventDefault();
                    alerta(texto);
                } else {
                    texto = "No se ha podido completar la actualización del <br>registro , por un error inesperado... <br> Por favor consulte con el administrador ";
                    error(texto);

                }
            });

        }

    }

    function eliminar(id) {
        if (confirm("Desea eliminar el registro seleccionado?") == true) {
            var parametros = "id=" + id;
            $.post("?modulo=eliminar-producto", parametros, function(respuesta) {
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
            $.post("?modulo=eliminar-todo-producto", parametros, function(respuesta) {
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