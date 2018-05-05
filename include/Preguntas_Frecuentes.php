<?php
    include 'generic_validate_session.php';
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'generic_head.php'; ?><!--Se incluye el head genérico-->
</head>
<body>
<header>
    <?php
    include 'generic_header2.php';//Se incluye el header especifico para el index
    ?>
</header>
<label></label>
<!--Recuadro de Inición de sesión-->
<section id="section_wrap">
    <form class="form-actions" style="margin: 0 auto !important; width: 220px;" action="../index.php" method="POST">
        <div class="control-group">
            <label class="control-label" for="email">Correo</label>
            <div class="controls">
                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" value="prueba@correo.com">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="pass">Contraseña</label>
            <div class="controls">
                <input type="password" id="pass" name="pass" placeholder="******" value="prueba">
                <input type="hidden" name="op" id="op" value="usrlogin"/>
                <input type="hidden" name="ti" id="ti"/>
                <input type="hidden" name="ke" id="ke"/>
                <!--<input type="hidden" name="fuente" id="fuente" value="franquicias_web"/>-->
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls" style="color: red !important;">
                <?php echo $mensaje ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit"  class="btn btn-info">Ingresar</button>
            </div>
        </div>
    </form>
</section>
<!--FIN Recuerdo de inición de sesión-->
<footer id="footer_wrap">
    <?php include 'include/generic_footer.php'; ?>
</footer>
<script type="text/javascript">
    $(document).ready(function(){
        $('#ti').val(_utval);
        $('#ke').val(_gcode);
    });
</script>
</body>
</html>