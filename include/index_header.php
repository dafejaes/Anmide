<?php
if (isset($_SESSION['usuario'])) {//Por si ya se hizo sesión anteriormente
    ?>
    <div align="right" style="color: green">
        <img src="images/log.png" width="20px">
        <?php
        echo $_SESSION['usuario']['nombre'];
        ?>
    </div>
    <?php
}else{
    ?>
    <div align="right" style="color: red">
        <img src="images/log.png" width="20px">
        <?php
        echo "Inicie sesión";
        ?>
    </div>
    <?php
}
?>
<div align="center">
    <img src="images/favicon2.png" alt="AntioquiaMide"/>
</div>
