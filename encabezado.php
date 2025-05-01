
<div class="imglogo">
    <img src="img/unnamed.jpg" alt="" class="logo">
</div>
<div class="titienda">
    tienda 
</div>
<div class="ussesa">
    <div><i class="fa-solid fa-user"></i></div>
    <div class="sesa">
        <div>
            <p class="testc">
                <?php
                // Asegúrate de iniciar la sesión antes de usar $_SESSION

                if (!empty($_SESSION['nombre'])) {
                    echo $_SESSION['nombre'];
                } else {
                    header("Location: ?modulo=inicio");
                    exit(); 
                }
                ?>
            </p>
        </div>
        <div class="salir">
            <a href="?modulo=sesion-cerrar-sesion"><b>SALIR </b> <i id="col" class=" fa-solid fa-share-from-square"></i></a>

        </div>
    </div>
</div>