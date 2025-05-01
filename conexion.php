<?php
session_start();
$conexion = mysqli_connect("127.0.0.1", "root", "", "tienda") or die('error en la conexion a la Base de Datos');
$conexion->set_charset("utf8");
