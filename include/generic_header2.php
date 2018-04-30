<?php

    //Creación e inicialización de variables
    $usuario="Inicie Sesion";
    $bandera=False;

    if(isset($_SESSION['usuario'])){//Por si ya se inició sesión anteriormente
        $usuario=$_SESSION['usuario']['nombre'];//Se recibe el nombre de la base de datos
        $bandera=True;//Se informa que ya se inició sesión
    }
    echo "<div align='right' style=".($bandera ? "'color: green'":"'color: red'").">"; //Se muestra al usuario su nombre
        echo "<img src='images/log.png' width='20px'>";//Logo de sesión que luego cambiará por el del usuario logueado
        echo $usuario;//Mensaje inicial o el nombre del usuario
    echo "</div>";

?>

<div align="center">
    <img src="images/favicon2.png" alt="AntioquiaMide"/<!--Se pone el logo representativo de AnMide con el de bioingeniería-->
</div>
