<div id="tabla">

    <div id="contenido-tabla" class="conte">

    </div>

</div>

<!-- ----------------script------------ -->

<script type="text/javascript">
    $("#estoy").html("<i class='fa-solid fa-arrow-up-right-dots'></i> MEJORES VENTAS");

    var pagina = 1;

    $(document).ready(function() {
        cargar_datos();


    });


    function cargar_datos() {
        $("#contenido-tabla").load("?modulo=cargar-mejor-venta&pagina=" + pagina);

    }



    function ir_a_pagina(p) {
        pagina = p;
        cargar_datos();
    }
</script>