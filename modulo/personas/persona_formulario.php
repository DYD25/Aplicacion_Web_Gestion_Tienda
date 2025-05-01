<div id="tabla">

    <div id="contenido-tabla" class="conte">

    </div>

    <div id="clientediv">
        <form id="clienteform" method="post">
            <input type="hidden" id="idper" name="idper" />
            <div class="group">
                <div class="input-group">
                    <select name="tip" id="tip" class="input">
                        <?php
                        $buscar = "select * from tipo_documento"; //se hace una consulta
                        $resultado = mysqli_query($conexion, $buscar); //la manada la consulta
                        while ($guarda = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='$guarda[Id]'> $guarda[Nombre] </option>'"; //genera un option automatico
                        }
                        ?>
                    </select>
                    <label class="label">Tipo Identificación</label>
                </div>
                <div class="input-group">
                    <input type="text" id="iden" name="iden" class="input" required>
                    <label class="label">Numero de Identificacion</label>
                </div>
            </div>

            <div class="group">
                <div class="input-group">
                    <input type="text" id="nom" name="nom" class="input" required>
                    <label class="label">Nombre(s)</label>
                </div>
                <div class="input-group">
                    <input type="text" id="ape" name="ape" class="input" required>
                    <label class="label">Apellidos</label>
                </div>
            </div>

            <div class="group">
                <div class="input-group">
                    <input type="text" id="dir" name="dir" class="input" required>
                    <label class="label">Dirección</label>
                </div>
                <div class="input-group">
                    <input type="text" id="tel" name="tel" class="input" required>
                    <label class="label">Teléfono</label>
                </div>
            </div>
            <div class="group">
                <div class="input-group">
                    <input type="email" id="cor" name="cor" class="input" required>
                    <label class="label">Corro electrónico</label>
                </div>
                <div class="input-group">
                    <input type="password" id="cont" name="cont" class="input cont" required>
                    <label class="label">Contraseña</label>
                </div>
                <div class="input-group">
                    <input type="password" id="conf" name="conf" class="input cont" required>
                    <label class="label">Confirmar</label>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- ----------------script------------ -->

<script type="text/javascript">
    $("#estoy").html("<i class='fa-solid fa-users'></i>  CLIENTES");
    $("#nuevo").html("<a href='#' id='nue_clie'> <i id='col' class='fa-solid fa-user-plus'></i> CREAR NUEVO</a>");

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();
        $("#clienteform").hide();
    });

    function cargar_datos() {
        $("#contenido-tabla").load("?modulo=persona-cargar-datos&pagina=" + pagina);
    }

    $('#nue_clie').click(function() {
        $("#contenido-tabla").hide();
        $("#nue_clie").hide();
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-users'></i></a> <span>REGISTRAR CLIENTE</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="registrar()" class="guardar" id="gua_cli"> Guardar </button>');

        $("#clienteform").show();

    });

    function registrar() {

        if ($("#cont").val() === $("#conf").val()) {

            var parametros = $("#clienteform").serialize();

            $.post("?modulo=persona-registrar", parametros, function(respuesta) {
                var guardar_respuesta = jQuery.parseJSON(respuesta);

                if (guardar_respuesta.error == false) {
                    $("#estoy").html("<i class='fa-solid fa-users'></i> <span> CLIENTES</span>");
                    $("#clienteform").hide();
                    $("#contenido-tabla").show();
                    $("#nue_clie").show();
                    cargar_datos();
                    texto = "Se ha registrado con exito ";
                    exito(texto);
                    $("#clienteform").get(0).reset(); //Limpiar el formulario
                    $("#acciones").html("");

                } else if (guardar_respuesta.error2 == true) {
                    texto = "La persona " + guardar_respuesta.nom + " ya se encuentra registrada";
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

        } else if ($("#cont").val() != $("#conf").val()) {
            x = "Por favor revisar que las contraseña coincidan";
            alerta(x);
            event.preventDefault();

        } else {
            x = "Ha resultado un error inesperado comuníquese con el administrador";
            error(x);
            event.preventDefault();
        }
    }

    function modificar(id) {
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-user-pen'></i></a> <span>ACTUALIZAR CLIENTE</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="actualizar()" class="guardar" "> Actualizar </button>');
        $("#contenido-tabla").hide();
        $("#clienteform").show();
        $("#nue_clie").hide();

        var parametros = "id=" + id;
        $.get("?modulo=persona-consulta-datos", parametros, function(respuesta) {
            var guarda = jQuery.parseJSON(respuesta);

            $("#idper").val(guarda.Id);
            $("#tip").val(guarda.TipoId);
            $("#iden").val(guarda.Identificacion);
            $("#nom").val(guarda.Nombre);
            $("#ape").val(guarda.Apellido);
            $("#cor").val(guarda.Correo);
            $("#tel").val(guarda.Telefono);
            $("#dir").val(guarda.Direccion);

        });
    }

    function actualizar() {

        if ($("#cont").val() === $("#conf").val() && !$("#cont").val() == "") {

            if (confirm("¿Realmente desea actualizar el registro seleccionado?") == true) {
                var parametros = $("#clienteform").serialize();

                $.post("?modulo=persona-actualizar-datos", parametros, function(respuesta) {

                    var guardar_respuesta = jQuery.parseJSON(respuesta);

                    if (guardar_respuesta.error == false) {
                        $("#estoy").html("<i class='fa-solid fa-users'></i> <span> CLIENTES</span>");
                        $("#clienteform").hide();
                        $("#contenido-tabla").show();
                        $("#nue_clie").show();
                        cargar_datos();
                        texto = "Se ha actualizado con exito ";
                        exito(texto);
                        $("#clienteform").get(0).reset(); //Limpiar el formulario
                        $("#acciones").html("");

                    } else if (guardar_respuesta.error2 == true) {
                        texto = "La persona " + guardar_respuesta.nom + " ya se encuentra registrada <br y no ha realizado ningun cambio";
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
        } else {
            texto = "Las contraseñas no son coinciden o hay campos vacios.<br> Por favor verifique ...";
            alerta(texto);
            event.preventDefault();
        }

    }
 
    function eliminar(id) {
        if (confirm("Desea eliminar el registro seleccionado?") == true) {
            var parametros = "id=" + id;

            $.post("?modulo=persona-eliminar-datos", parametros, function(respuesta) {
                var guardar_resp = jQuery.parseJSON(respuesta);
                if (guardar_resp.error == false) {
                    texto = "ha registro ha siod eliminado con un exito";
                    exito(texto);
                    cargar_datos();
                } else {
                    texto = "No se ha podido completar la eliminacion del <br>registro , por un error inesperado... <br> Por favor consulte con el administrador " + guardar_resp.mensaje ;
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