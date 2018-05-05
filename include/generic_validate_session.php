<?php
    session_start();//Inicio de sesión
    if (!isset($_SESSION['usuario'])){//si no se inició sesión anteriormente entonces regresar al index
        header('Location: index.php');
    }
    include 'SessionData.php';//Se incluye las clases de inicio de sesión
    $SESSION_DATA = new SessionData();//Se crea el objeto
?>