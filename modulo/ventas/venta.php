<div id="tabla">
    <div id="contenido-tabla" class="conte">

    </div>

    <div id="clientediv">
        <form id="clienteform" method="post">
            <input type="hidden" id="idper" name="idper" />
            <input type="hidden" id="nomprod" name="nomprod" />
            <input type="hidden" id="nompers" name="nompers" />

            <div class="group">
                <div class="input-group">
                    <select name="per" id="per" class="input">
                        <option value="">Futuro cliente</option>
                        <?php
                        $buscar = "SELECT p.Id Id,d.Abre, p.Identificacion ide, CONCAT(p.Nombre,' ',p.Apellido) nom
                        FROM personas p
                        JOIN tipo_documento d ON p.TipoId = d.Id";
                        $resultado = mysqli_query($conexion, $buscar); //la manada la consulta
                        while ($guarda = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='$guarda[Id]'>$guarda[Abre]: $guarda[ide]   $guarda[nom]  </option>'"; //genera un option automatico
                        }
                        ?>
                    </select>
                    <label class="label">Cliente</label>
                </div>
                <div class="input-group">
                    <select name="pro" id="pro" class="input">

                    </select>
                    <label class="label">Productos</label>
                </div>
            </div>

            <div class="group">
                <div class="input-group">
                    <input type="number" id="can" name="can" class="input" required>
                    <label class="label">Cantidad</label>
                </div>
                <div class="input-group">
                    <input type="hidden" id="val" name="val">
                    <input type="number" id="valo" name="val" class="input " disabled>
                    <label id="lab" class="label">Valor total a pagar</label>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ----------------script------------ -->

<script type="text/javascript">
    $("#estoy").html("<i class='fa-solid fa-cart-plus'></i> PRODUCTOS VENDIDOS");
    $("#nuevo").html("<a href='#' id='nue_clie'> <i id='col' class='fa-solid fa-cart-plus'></i> VENDER PRODUCTO</a>");

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();

        cargar_productos();

        $("#clienteform").hide();

        $("#can").keyup(function() {
            consul_reg_vent($("#can").val(), $("#pro").val());

        });
        $("#pro").change(function() {
            consul_reg_vent($("#can").val(), $("#pro").val());

        });

    });


    function cargar_productos() {
        $.get("?modulo=cargar-productos-venta", function(data) {
            let productos = jQuery.parseJSON(data);
            $("#pro").html("");
            for (let index in productos) {
                producto = productos[index];

                $("#pro").append('<option value=' + producto.valor + '>' + producto.texto + '</option>');

            }

        });
    }

    function cargar_datos() {
        $("#contenido-tabla").load("?modulo=cargar-venta&pagina=" + pagina);
    }

    function consul_reg_vent(c, p) {
        var parametros = "c=" + c + "&p=" + p;
        if (c == "") {
            $("#valo").val("");
            $("#valo").removeClass("inp")
            $("#lab").removeClass("lab")
        } else {
            $.get("?modulo=consulta-reg-venta", parametros, function(respuesta) {
                var guarda = jQuery.parseJSON(respuesta);
                if (guarda.error == false) {
                    $("#valo").addClass("inp");
                    $("#lab").addClass("lab");
                    $("#valo").val(guarda.precio);
                    $("#val").val(guarda.precio);
                } else {
                    texto = "No hay la cantidad de productos a comprar";
                    event.preventDefault();
                    alerta(texto);
                }
            });
        }
    }

    $('#nue_clie').click(function() {
        $("#contenido-tabla").hide();
        $("#nue_clie").hide();
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-cart-plus'></i></a> <span>REGISTRAR VENTA</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="registrar()" class="guardar" id="gua_cli"> Guardar </button>');
        cargar_datos();
        $("#clienteform").show();

    });

    function registrar() {
        var parametros = $("#clienteform").serialize();
        $.post("?modulo=registrar-venta", parametros, function(respuesta) {
            var guardar_respuesta = jQuery.parseJSON(respuesta);
            if (guardar_respuesta.error == false) {
                $("#estoy").html("<i class='fa-solid fa-users'></i> <span> PRODUCTOS VENDIDOS</span>");
                $("#clienteform").hide();
                $("#contenido-tabla").show();
                $("#nue_clie").show();
                cargar_datos();
                cargar_productos();
                texto = "Se ha registrado con exito ";
                exito(texto);
                $("#clienteform").get(0).reset();
                $("#acciones").html("");

            } else if (guardar_respuesta.error2 == true) {
                texto = "El venta " + guardar_respuesta.nom + " ya se encuentra registrada";
                event.preventDefault();
                alerta(texto);
            } else if (guardar_respuesta.error3 == true) {
                texto = "Verifique por favor que todos los campos estén diligenciados";
                event.preventDefault();
                alerta(texto);
            } else if (guardar_respuesta.error == true) {
                texto = "No se ha podido completar la solicitud de <br>registro , por un error inesperado... <br> Por favor consulte con el administrador ";
                event.preventDefault();
                error(texto);
            }
        });
    }

    function modificar(id) {
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-cart-plus'></i></a> <span>ACTUALIZAR VENTA</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="actualizar()" class="guardar" "> Actualizar </button>');
        $("#contenido-tabla").hide();
        $("#clienteform").show();
        $("#nue_clie").hide();

        var parametros = "id=" + id;
        $.get("?modulo=consulta-venta", parametros, function(respuesta) {
            var guarda = jQuery.parseJSON(respuesta);
            $("#valo").addClass("inp");
            $("#lab").addClass("lab");
            $("#valo").val(guarda.precio);
            $("#val").val(guarda.precio);

            $("#idper").val(guarda.Id);
            $("#per").val(guarda.PersonaId);

            $("#can").val(guarda.Cantidad);
            $("#val").val(guarda.Valor);
            $("#valo").val(guarda.Valor);

            if (guarda.EstadoProducto = "2") {
                $("#nompers").val(guarda.PersonaId);
                $("#nomprod").val(guarda.Nombre);
                $("#pro").append('<option value=' + guarda.ProductoId + '>' + guarda.NombreProducto + guarda.cantidad + '</option>');
            }
            $("#pro").val(guarda.ProductoId);
        });
    }

    function actualizar() {

        if (confirm("¿Realmente desea actualizar el registro seleccionado?") == true) {
            var parametros = $("#clienteform").serialize();
            $.post("?modulo=actualizar-venta", parametros, function(respuesta) {

                var guardar_respuesta = jQuery.parseJSON(respuesta);

                if (guardar_respuesta.error == false) {
                    $("#estoy").html("<i class='fa-solid fa-users'></i> <span> PRODUCTOS VENDIDOS</span>");
                    $("#clienteform").hide();
                    $("#contenido-tabla").show();
                    $("#nue_clie").show();
                    cargar_datos();
                    texto = "Se ha actualizado con exito ";
                    exito(texto);
                    $("#clienteform").get(0).reset();
                    $("#acciones").html("");

                } else if (guardar_respuesta.error2 == true) {
                    texto = "El producto ya se encuentra registrada <br y no ha realizado ningun cambio";
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

    function eliminar(id, can, nompro) {
        if (confirm("Desea eliminar el registro seleccionado?") == true) {
            var parametros = "id=" + id + "&can=" + can + "&nompro=" + nompro;
            $.post("?modulo=eliminar-venta", parametros, function(respuesta) {
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
            $.post("?modulo=eliminar-todo-venta", parametros, function(respuesta) {
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