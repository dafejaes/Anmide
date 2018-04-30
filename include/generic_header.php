<div class="navbar">
    <img src="images/favicon3.png" alt="AntioquiaMide" width="250px"/>
</div>
<?php
    $usuario="Inicie Sesion";
    $bandera=False;

    if(isset($_SESSION['usuario'])){//Por si ya se inició sesión anteriormente
        $usuario=$_SESSION['usuario']['nombre'];
        $bandera=True;
    }

    echo "<div align='right' style=".($bandera ? "'color: green'":"'color: red'").">";
    echo "<img src='images/log.png' width='20px'>";
    echo $usuario;
    echo "</div>";
?>


