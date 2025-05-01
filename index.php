<?php

require_once("configuracion.php");

if ($diseno == "login") {
    require_once("login.php");
} else if ($diseno == "sistema") {
    require_once("index_tienda.php");
} else if ($diseno == "diseno_libre") {
    require_once("diseno_libre.php");
}
