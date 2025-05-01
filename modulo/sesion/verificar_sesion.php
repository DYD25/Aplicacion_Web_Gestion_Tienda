<?php

global $conexion;
$identifica = $_POST['usuario'];
$clave = $_POST['contrasena'];


$busqueda2 = "SELECT 
Identificacion iden, Nombre nombre, Contrasena contra
FROM  personas 
WHERE Identificacion='$identifica'";

$consulta2 = mysqli_query($conexion, $busqueda2);
$resultado = [];

if ($guardar2 = mysqli_fetch_assoc($consulta2)) {

    $contr=$guardar2['contra'];
    $usa=$guardar2['iden'];
    #$id_rol=$guardar2['roles'];

    if ($clave == $contr and $identifica== $usa) {

        $_SESSION['identifica'] =$guardar2['iden'];
        $_SESSION['nombre'] = $guardar2['nombre'];

       # $_SESSION['permisos'] = [];

        $resultado['error'] = false;

       /* $buscar_permiso="SELECT 
            p.id_permiso, p.nombre
        FROM
            permiso_rol pr
        JOIN
            permiso p ON pr.id_permiso = p.id_permiso
        JOIN
            rol_persona rp ON rp.id_rol = pr.id_rol
        JOIN
            persona per ON per.id_persona = rp.id_persona
        WHERE
            per.identificacion ='$identifica'";

         $consulta_permiso=mysqli_query($conexion, $buscar_permiso);
        while ($guardar_permiso = mysqli_fetch_assoc($consulta_permiso)) {
            $_SESSION['permisos'][]= $guardar_permiso['nombre'];
    }*/
    } else {
        $resultado['error'] = true;
        
    }
}else{
    $resultado['error'] = true;

}

echo json_encode($resultado);


