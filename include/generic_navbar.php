<?php

?>
<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav">
	    <?php 
	    if($SESSION_DATA->getPermission(1)){
	    ?>
            <li <?php if ($_ACTIVE_SIDEBAR == "clientes") echo 'class="active"'; ?>><a href="clientes.php">Clientes</a></li>
            <li class="divider-vertical"></li>
	    <?php 
	    }
	    if($SESSION_DATA->getPermission(5)){
	    ?>
            <li <?php if ($_ACTIVE_SIDEBAR == "usuario") echo 'class="active"'; ?>><a href="usuario.php">Usuarios</a></li>
            <li class="divider-vertical"></li>
	    <?php 
	    }
	    ?>
            
        </ul>
        <ul class="nav pull-right">
            <li><a href="logout.php">Salir</a></li>
            <li class="divider-vertical"></li>
<!--            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi cuenta <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Editar cuenta</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Cerrar Sesión</a></li>
                </ul>
            </li>-->
        </ul>
    </div>
</div>