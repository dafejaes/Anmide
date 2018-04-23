<?php

class SessionData {

    /*Creación de variables*/
    private $THE_KEY;
    private $THE_RANDOM;

    function __construct() {//Definición de las variables
	    $this->THE_KEY = '9fc10dd65f77fb6c78cda83e986d969eee8e0d9c';
	    $this->THE_RANDOM = sha1(rand(100, 2000));
    }

    public function getKey() {//Envío de THE_KEY
	    return $this->THE_KEY;
    }

    public function getRandom() {//Envío de THE_RANDOM
	    return $this->THE_RANDOM;
    }

    public function getPermission($id) {//Obtener todos los permisos del usuario
	    $permisos = $_SESSION['usuario']['permisos'];
	    return (in_array($id, $permisos));
    }

    public function getUserCustomerId() {//Obtener el id del cliente del usuario
	    return $_SESSION['usuario']['idcli'];
    }

    public function getUserCustomerName() {//Obtener el Nombre del cliente del usuario
	    return $_SESSION['usuario']['clientenombre'];
    }

    public function getUserId() {//Obtener el id del usuario
	    if (isset($_SESSION['usuario'])) {//Si ya existe
	        return $_SESSION['usuario']['id'];
	    } else {//Si no existe crea uno nuevo
	        return sha1(rand(100, 2000));
	    }
    }

    public function getKeyUser() {
	    if (isset($_SESSION['usuario'])) {//Si ya existe
	        $userid = $_SESSION['usuario']['id'];
	        return sha1($userid . $this->THE_KEY . $this->THE_RANDOM);
	    } else {
	        return sha1(rand(100, 2000));
	    }
    }

    public function getKeyGeneric() {
	    return sha1($this->THE_KEY . $this->THE_RANDOM);
    }

    public function getUserFullName() {
	    $fullname = $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido'];
	    return $fullname;
    }

}

?>
