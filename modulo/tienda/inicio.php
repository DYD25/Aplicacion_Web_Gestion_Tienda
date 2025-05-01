<div id="tabla">
    <div class="tablagrafica">
        <div id="contenido" class="conten ">
            <canvas id="mejorventa"></canvas>
        </div>
        <div id="contenido2" class=" conten">
            <canvas id="cienteventa"></canvas>
        </div>
    </div>
    <div id="diven">
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
    $("#estoy").html("<i class='fa-solid fa-cart-plus'></i> PRODUCTOS MAS VENDIDOS");
    $("#nuevo").html("<a href='#' id='nue_clie'> <i id='col' class='fa-solid fa-cart-plus'></i> VENDER PRODUCTO</a>");

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();
        cargar_productos();
        $("#can").keyup(function() {
            consul_reg_vent($("#can").val(), $("#pro").val());
        });
        $("#pro").change(function() {
            consul_reg_vent($("#can").val(), $("#pro").val());
        });
    });

    function cargar_datos() {
        mejoresventas();
        consolidado();
        $("#cienteventa").show();
        $("#mejorventa").show();
    }

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

    function registrar() {
        var parametros = $("#clienteform").serialize();
        $.post("?modulo=registrar-venta", parametros, function(respuesta) {
            var guardar_respuesta = jQuery.parseJSON(respuesta);
            if (guardar_respuesta.error == false) {
                $("#estoy").html("<i class='fa-solid fa-users'></i> <span> PRODUCTOS VENDIDOS</span>");

                window.location = "?modulo=tienda"
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

    $('#nue_clie').click(function() {
        $("#nue_clie").hide();
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-cart-plus'></i></a> <span>REGISTRAR VENTA</span>");
        $("#acciones").html('<a href="" class="cancelar"> Cancelar </a> <button type="button" onclick="registrar()" class="guardar" id="gua_cli"> Guardar </button>');
        $("#cienteventa").hide();
        $("#mejorventa").hide();
        $("#contenido").hide();
        $("#contenido2").hide();
        $("#clienteform").show();

    });

    function mejoresventas() {
        $("#clienteform").hide();

        var parametros = 1;
        $.get("?modulo=cargar-venta-mejor", parametros, function(data) {
            let productos = jQuery.parseJSON(data);
            var tipo = "polarArea";
            var nombregradica = "MEJORES VENTAS";
            var camid = $('#mejorventa');
            var col = ['#00F2C9', '#58E0FF', '#afe7ff', '#a39bf5', '#8132ff'];

            nombre = [];
            cantidad = [];
            if (productos.length > 0) {
                for (let index in productos) {
                    producto = productos[index];
                    nombre.push(producto.nombre);
                    cantidad.push(producto.cantidad);
                }
            } else {
                $('#contenido').html('<h1>No hay datos para mostrar grafica </h1>');
            }
            grafico(nombre, cantidad, tipo, nombregradica, camid, col);
        });
    }

    function consolidado() {
        $("#clienteform").hide();
        var parametros = 1;
        $.get("?modulo=cargar-consolidado-inicio", parametros, function(data) {
            let clientes = jQuery.parseJSON(data);
            var tipo = "doughnut";
            var nombregradica = "CONSOLIDADO DE COMPRAS CLIENTES";
            var camid = $('#cienteventa');
            var col = [' #adfabe', '#6bffe9', '#96cff2', '#cb93fd', '#ece7a2'];
            nombre = [];
            valor = [];
            if (clientes.length > 0) {
                for (let index in clientes) {
                    cliente = clientes[index];
                    nombre.push(cliente.nombre);
                    valor.push(cliente.valor);
                }
            } else {
                $('#contenido2').html('<h1>No hay datos para mostrar grafica </h1>');
            }
            grafico(nombre, valor, tipo, nombregradica, camid, col);

        });
    }

    
    
    function grafico(nombre, cantidad, tipo, nombregradica, camid, col) {

        const ctx = camid;
        new Chart(ctx, {
            type: tipo,
            data: {
                labels: nombre,
                datasets: [{
                    label: nombregradica,
                    data: cantidad,
                    backgroundColor: col,
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: nombregradica,
                        font: {
                            size: 20
                        }
                    },
                    legend: {
                        display: true,
                        position: 'right', // Puedes ajustar la posición según tus necesidades
                        labels: {
                            boxWidth: 20, // Ancho de las cajas de color en la leyenda
                            font: {
                                size: 14 // Tamaño de la fuente de la leyenda
                            }
                        }
                    }

                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });

    }

   // function grafica(nombre, total) {
            // const ctx = $('#grafica')[0].getContext('2d');

            // if (this.chart) {
            //     this.chart.destroy();
            // }

            // this.chart = new Chart(ctx, {
            //     type: 'pie',
            //     data: {
            //         labels: nombre,
            //         datasets: [{
            //             label: 'Clientes Frecuentes',
            //             data: total,
            //             backgroundColor: this.generarColoresAleatorios(nombre.length),
            //             borderWidth: 2
            //         }]
            //     },
            //     options: {
            //         responsive: true,
            //         plugins: {
            //             title: {
            //                 display: true,
            //                 text: 'Clientes Frecuentes',
            //                 font: {
            //                     size: 20
            //                 }
            //             },
            //             legend: {
            //                 display: true,
            //                 position: 'top',
            //                 labels: {
            //                     boxWidth: 20,
            //                 }
            //             }
            //         }
            //     },
            //     scales: {
            //         y: {
            //             beginAtZero: true
            //         }
            //     }

            // });

        // }
</script>