<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Camilo Garzon Calle
 */
class ControllerUser {

    private $conexion, $CDB, $op, $id, $euid, $sdid;
    private $UTILITY;
    private $response;

    function __construct() {
        $this->CDB = new ConectionDb();
        $this->UTILITY = new Util();
        $this->conexion = $this->CDB->openConect();
        $rqst = $_REQUEST;
        $this->op = isset($rqst['op']) ? $rqst['op'] : '';
        $this->id = isset($rqst['id']) ? intval($rqst['id']) : 0;
        $this->ke = isset($rqst['ke']) ? $rqst['ke'] : '';
        $this->lu = isset($rqst['lu']) ? $rqst['lu'] : '';
        $this->ti = isset($rqst['ti']) ? $rqst['ti'] : '';
        if ($this->op != 'usrlogin') {
            if (!$this->UTILITY->validate_key($this->ke, $this->ti, $this->lu)) {
                $this->op = 'noautorizado';
            }
        } else {
            if (!$this->UTILITY->validate_key($this->ke, $this->ti)) {
                $this->op = 'noautorizado';
            }
        }
        if ($this->op == 'usrsave') {
            $this->idcli = isset($rqst['idcli']) ? $rqst['idcli'] : 0;
            $this->nombre = isset($rqst['nombre']) ? $rqst['nombre'] : '';
            $this->apellido = isset($rqst['apellido']) ? $rqst['apellido'] : '';
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->identificacion = isset($rqst['identificacion']) ? $rqst['identificacion'] : '';
            $this->cargo = isset($rqst['cargo']) ? $rqst['cargo'] : '';
            $this->telefono = isset($rqst['telefono']) ? $rqst['telefono'] : '';
            $this->celular = isset($rqst['celular']) ? $rqst['celular'] : '';
            $this->pais = isset($rqst['pais']) ? $rqst['pais'] : '';
            $this->departamento = isset($rqst['departamento']) ? $rqst['departamento'] : '';
            $this->ciudad = isset($rqst['ciudad']) ? $rqst['ciudad'] : '';
            $this->direccion = isset($rqst['direccion']) ? $rqst['direccion'] : '';
            $this->habilitado = isset($rqst['habilitado']) ? intval($rqst['habilitado']) : 0;
            $this->usrsave();
        } else if ($this->op == 'usrlogin') {
            $this->email = isset($rqst['email']) ? $rqst['email'] : '';
            $this->pass = isset($rqst['pass']) ? $rqst['pass'] : '';
            $this->usrlogin();
        } else if ($this->op == 'usrget') {
            $this->usrget();
        } else if ($this->op == 'usrprfget') {
            $this->usrprfget();
        } else if ($this->op == 'usrprfsave') {
            $this->chk = isset($rqst['chk']) ? $rqst['chk'] : '';
            $this->usrprfsave();
        } else if ($this->op == 'usrdelete') {
            $this->usrdelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**
     * Metodo para guardar y actualizar
     */
    private function usrsave() {
        $id = 0;
        $resultado = 0;
        $pass = '';
        if ($this->UTILITY->validate_email($this->email)) {
            $arrjson = $this->UTILITY->error_wrong_email();
        } else {
            if ($this->id > 0) {
                //se verifica que el email está disponible
                $q = "SELECT usr_id FROM dmt_usuario WHERE usr_email = '" . $this->email . "' AND usr_id != $this->id ";
                $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                if ($resultado == 0) {
                    //actualiza la informacion
                    $q = "SELECT usr_id FROM dmt_usuario WHERE usr_id = " . $this->id;
                    $con = mysqli_query($this->conexion,$q) or die(mysql_error() . "***ERROR: " . $q);
                    while ($obj = mysqli_fetch_object($con)) {
                        $id = $obj->usr_id;
                        if (strlen($this->pass) > 2) {
                            $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                        }
                        $table = "dmt_usuario";
                        $arrfieldscomma = array(
                            'usr_nombre' => $this->nombre,
                            'usr_apellido' => $this->apellido,
                            'usr_email' => $this->email,
                            'usr_pass' => $pass,
                            'usr_cargo' => $this->cargo,
                            'usr_identificacion' => $this->identificacion,
                            'usr_celular' => $this->celular,
                            'usr_telefono' => $this->telefono,
                            'usr_pais' => $this->pais,
                            'usr_departamento' => $this->departamento,
                            'usr_ciudad' => $this->ciudad,
                            'usr_direccion' => $this->direccion);
                        $arrfieldsnocomma = array('dmt_cliente_cli_id' => $this->idcli,'usr_dtcreate' => $this->UTILITY->date_now_server(), 'usr_habilitado' => $this->habilitado);
                        $q = $this->UTILITY->make_query_update($table, "usr_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                        mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                        $arrjson = array('output' => array('valid' => true, 'id' => $id));
                    }
                } else {
                    $arrjson = $this->UTILITY->error_user_already_exist();
                }
            } else {
                //se verifica que el email está disponible
                $q = "SELECT usr_id FROM dmt_usuario WHERE usr_email = '" . $this->email . "'";
                $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                if ($resultado == 0) {
                    if (strlen($this->pass) > 2) {
                        $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                    }
                    $this->pass = $pass;
                    $q = "INSERT INTO dmt_usuario (usr_dtcreate, dmt_cliente_cli_id, usr_habilitado, usr_nombre, usr_apellido, usr_cargo, usr_email, usr_pass, usr_identificacion, usr_celular, usr_telefono, usr_pais, usr_departamento, usr_ciudad, usr_direccion) VALUES (" . $this->UTILITY->date_now_server() . ", $this->idcli, $this->habilitado, '$this->nombre', '$this->apellido', '$this->cargo', '$this->email', '$this->pass', '$this->identificacion', '$this->celular', '$this->telefono', '$this->pais', '$this->departamento', '$this->ciudad', '$this->direccion')";
                    mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                    $id = mysqli_insert_id();
                    $arrjson = array('output' => array('valid' => true, 'id' => $id));
                } else {
                    $arrjson = $this->UTILITY->error_user_already_exist();
                }
            }
        }
        $this->response = ($arrjson);
    }

    public function usrget() {
        $q = "SELECT * FROM dmt_usuario ORDER BY usr_nombre ASC";
        if ($this->id > 0) {
            $q = "SELECT * FROM dmt_usuario WHERE usr_id = " . $this->id;
        }
        //if ($this->sdid > 0) {
        //    $q = "SELECT * FROM fir_usuario WHERE fir_sede_sde_id = " . $this->sdid;
        //}
        //if ($this->euid > 0) {
        //    $q = "SELECT * FROM fir_usuario WHERE fir_empresa_emp_id = " . $this->euid;
        //}
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $resultado = mysqli_num_rows($con);
        $arr = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->usr_id,
                'idcli' => $obj->dmt_cliente_cli_id,
                'nombre' => ($obj->usr_nombre),
                'apellido' => ($obj->usr_apellido),
                'cargo' => ($obj->usr_cargo),
                'email' => ($obj->usr_email),
                'identificacion' => ($obj->usr_identificacion),
                'celular' => ($obj->usr_celular),
                'telefono' => ($obj->usr_telefono),
                'pais' => ($obj->usr_pais),
                'departamento' => ($obj->usr_departamento),
                'ciudad' => ($obj->usr_ciudad),
                'direccion' => ($obj->usr_direccion),
                'habilitado' => ($obj->usr_habilitado),
                'dtcreate' => ($obj->usr_dtcreate));
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function usrdelete() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "DELETE FROM dmt_usuario WHERE usr_id = " . $this->id;
            mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    /**
     * Metodo para loguearse
     */
    private function usrlogin() {
        $resultado = 0;
        if ($this->UTILITY->validate_email($this->email)) {
            $arrjson = $this->UTILITY->error_wrong_email();//
        } else {
            if ($this->pass == "") {
                $arrjson = $this->UTILITY->error_missing_data();
            } else {
                $pass = $this->UTILITY->make_hash_pass($this->email, $this->pass);
                $q = "SELECT * FROM dmt_usuario WHERE usr_email = '$this->email' AND usr_pass = '$pass' AND usr_habilitado = 1";
                $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                $resultado = mysqli_num_rows($con);
                while ($obj = mysqli_fetch_object($con)) {
                    $q2 = "SELECT cli_id, cli_nombre FROM dmt_cliente WHERE cli_id = " . $obj->dmt_cliente_cli_id;
                    $con2 = mysqli_query($this->conexion,$q2) or die(mysqli_error() . "***ERROR: " . $q2);
                    $cliente = '0';
                    $clientenombre = 'ninguno';
                    while ($obj2 = mysqli_fetch_object($con2)) {
                        $cliente = $obj2->cli_id;
                        $clientenombre = $obj2->cli_nombre;
                    }

                    //se consultan los perfiles asignados
                    $q3 = "SELECT dmt_perfiles_prf_id FROM dmt_usuario_has_dmt_perfiles WHERE dmt_usuario_usr_id = $obj->usr_id ORDER BY dmt_perfiles_prf_id ASC";
                    $con3 = mysqli_query($this->conexion,$q3) or die(mysqli_error() . "***ERROR: " . $q3);
                    $arrassigned = array();
                    while ($obj3 = mysqli_fetch_object($con3)) {
                        $arrassigned[] = ($obj3->dmt_perfiles_prf_id);
                    }
                    $arrjson = array('output' => array(
                            'valid' => true,
                            'id' => $obj->usr_id,
                            'idcli' => ($cliente),
                            'clientenombre' => ($clientenombre),
                            'nombre' => ($obj->usr_nombre),
                            'apellido' => ($obj->usr_apellido),
                            'cargo' => ($obj->usr_cargo),
                            'email' => ($obj->usr_email),
                            'identificacion' => ($obj->usr_identificacion),
                            'celular' => ($obj->usr_celular),
                            'telefono' => ($obj->usr_telefono),
                            'pais' => ($obj->usr_pais),
                            'departamento' => ($obj->usr_departamento),
                            'ciudad' => ($obj->usr_ciudad),
                            'direccion' => ($obj->usr_direccion),
                            'habilitado' => ($obj->usr_habilitado),
                            'dtcreate' => ($obj->usr_dtcreate),
                            'permisos' => $arrassigned));
                }
                if ($resultado == 0) {
                    $arrjson = $this->UTILITY->error_wrong_data_login();
                }
            }
        }
        $this->response = ($arrjson);
    }

    private function usrprfget() {
        //se consultan los perfiles asignados
        $q = "SELECT * FROM dmt_usuario_has_dmt_perfiles WHERE dmt_usuario_usr_id = $this->id ORDER BY dmt_perfiles_prf_id ASC";
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        $arrassigned = array();
        $arravailable = array();
        while ($obj = mysqli_fetch_object($con)) {
            $arrassigned[] = array('id' => $obj->dmt_perfiles_prf_id);
        }
        //se consultan los perfiles disponibles
        $q = "SELECT * FROM dmt_perfiles ORDER BY prf_nombre ASC";
        $con = mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
        while ($obj = mysqli_fetch_object($con)) {
            $arravailable[] = array(
                'id' => $obj->prf_id,
                'nombre' => $obj->prf_nombre,
                'descripcion' => $obj->prf_descripcion);
        }

        $arrjson = array('output' => array('valid' => true, 'available' => $arravailable, 'assigned' => $arrassigned));
        $this->response = ($arrjson);
    }

    private function usrprfsave() {
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "DELETE FROM dmt_usuario_has_dmt_perfiles WHERE dmt_usuario_usr_id = " . $this->id;
            mysqli_query($this->conexion, $q) or die(mysqli_error() . "***ERROR: " . $q);
            $arrchk = explode('-', $this->chk);
            for ($i = 0; $i < count($arrchk); $i++) {
                $prf_id = intval($arrchk[$i]);
                if ($prf_id > 0) {
                    $q = "INSERT INTO dmt_usuario_has_dmt_perfiles (dmt_usuario_usr_id, dmt_perfiles_prf_id, dtcreate) VALUES ($this->id, $prf_id, " . $this->UTILITY->date_now_server() . ")";
                    mysqli_query($this->conexion,$q) or die(mysqli_error() . "***ERROR: " . $q);
                }
            }
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    public function getResponse() {//Cierra la conexión y retorna la respuesta
        $this->CDB->closeConect();
        return $this->response;
    }

    public function getResponseJSON() {
        $this->CDB->closeConect();
        return json_encode($this->response);
    }

    public function setId($_id) {
        $this->id = $_id;
    }

    public function extraLogin($email, $pass) {
        $this->email = $email;
        $this->pass = $pass;
        $this->usrlogin();
    }

}

?>