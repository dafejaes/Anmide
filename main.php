<?php
include 'include/generic_validate_session.php';//Se valida la sesión, si se es correcta la validacion se quedará en main
?>

<!------FORMULARIO HTML-------------------------->
<!DOCTYPE html>
<html>
    <head>
	    <?php include 'include/generic_head.php'; ?><!--Incluir el head genérico-->
    </head>
    <body>
        <header>
	        <?php
	            include 'include/generic_header.php';//Incluir el header genérico
	        ?>
        </header>
        <section id="section_wrap"><!--Las opciones que tiene el usuario se encuentran aquí-->
            <div class="container">
		        <?php $_ACTIVE_SIDEBAR = ''; include 'include/generic_navbar.php'; ?><!--Se miran los permisos y se muestran las opciones-->
            </div>
	    <div class="container" style="height: 300px; margin: 0 auto !important; text-align: center;">
		<br><br>
		<h1>Bienvenido al sistema de metrología AntioquiaMide Señor(a)
		<?php 
            print_r($_SESSION['usuario']['nombre'])
        ?>
        </h1>
	    </div>	    
	</section>
	<footer id="footer_wrap">
	<?php include 'include/generic_footer.php'; ?>
	</footer>
    </body>
</html>