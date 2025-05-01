<div id="tabla">

    <div id="contenido-tabla" class="conte">

    </div>

</div>

<!-- ----------------script------------ -->

<script type="text/javascript">
    $("#estoy").html("<i class='fa-solid fa-bag-shopping'></i> CONSOLIDADO COMPRAS");
    $("#nuevo").html("<a href='#' id='nue_clie'> <i id='col' class='fa-solid fa-cart-arrow-down'></i> REGISTRO DE COMPRAS CLIENTES</a>");

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();


    });


    function cargar_datos() {
        $("#contenido-tabla").load("?modulo=consolidado-compras&pagina=" + pagina);
        $("#nue_clie").show();
    }

    function ver(id, per) {
        $("#contenido-tabla").load("?modulo=ver-detalle-cliente&pagina=" + pagina + "&iden=" + id);
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-cart-arrow-down'></i></a> <span>DETALLES DEL COMPRAS</span>");

    }
    $('#nue_clie').click(function() {
        $("#nue_clie").hide();
        $("#estoy").html("<a href=''><i  class='fa-solid fa-arrow-left'></i> <i class='fa-solid fa-bag-shopping'></i></a> <span>CONSOLIDADO COMPRAS</span>");
        $("#contenido-tabla").load("?modulo=cargar-detalle-cliente&pagina=" + pagina);

    });

    function ir_a_pagina(p) {
        pagina = p;
        cargar_datos();
    }
</script>