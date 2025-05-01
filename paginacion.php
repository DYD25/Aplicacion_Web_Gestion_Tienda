<?php
if ($pagina_actual > 1) {
    $p = $pagina_actual - 1;
    echo "<button class='pag' onclick='ir_a_pagina($p)'> < </button>";
}

if ($pagina_actual <= 4) {
    $num = 5;
    if ($num_paginas < 5) {
        $num = $num_paginas;
    }

    for ($i = 1; $i <= $num; $i++) {
        echo "<button class='pagina-$i pag' onclick='ir_a_pagina($i)'>$i</button>";
    }
    if ($num_paginas > 5) {
        echo "<button class='pag'>...</button>";
        echo "<button class='pagina-$num_paginas pag' onclick='ir_a_pagina($num_paginas)'> $num_paginas </button>";
    }
} else if ($pagina_actual >= $num_paginas - 5) {
    if ($num_paginas > 5) {
        //Ir  pagina 1
        echo "<button class='pagina-1 pag' onclick='ir_a_pagina(1)'>1</button>";
        //Ir a las últimas 5 paginas
        echo "<button>...</button>";
    }

    for ($i = $num_paginas - 4; $i <= $num_paginas; $i++) {
        echo "<button class='pagina-$i pag' onclick='ir_a_pagina($i)'>$i</button>";
    }
} else {
    echo "<button class='pagina-1 pag' onclick='ir_a_pagina(1)'>1</button>";
    echo "<button class='pag' >...</button>";
    $p = $pagina_actual - 1;
    echo "<button class='pagina-$p pag' onclick='ir_a_pagina($p)'>$p</button>";
    $p = $pagina_actual;
    echo "<button class='pagina-$p pag' onclick='ir_a_pagina($p)'>$p</button>";
    $p = $pagina_actual + 1;
    echo "<button class='pagina-$p pag' onclick='ir_a_pagina($p)'>$p</button>";
    echo "<button class='pag' >...</button>";
    echo "<button class='pagina-$num_paginas pag' onclick='ir_a_pagina($num_paginas)'> $num_paginas </button> ";
}

if ($pagina_actual < $num_paginas && $num_paginas > 5) {

    $p = $pagina_actual + 1;
    echo "<button class='pagina-$p pag' onclick='ir_a_pagina($p)'> > </button>";
}
?>

<script type="text/javascript">
    
    $(".pagina-<?php echo $pagina_actual ?>").addClass("pagina-activa");

</script>