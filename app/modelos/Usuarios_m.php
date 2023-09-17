<?php
// modelo para la gestion de usuarios
class Usuarios_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // leerUsu realiza la busqueda del usuario a partir del username
    public function leerUsu($usu){
        $cadSQL = "SELECT * FROM usuarios WHERE (username=:usu)";
        $this->consultar($cadSQL);
        $this->enlazar(":usu", $usu);
        $fila = $this->fila();
        return $fila;
    }
    // autenticar es usado a la hora de hacer login para confirmar que tanto el user como la contraseña son correctas
    public function autenticar($usu, $pass)
    {
        $cadSQL = "SELECT * FROM usuarios WHERE (username=:usu or email=:usu) and activo=1";
        $this->consultar($cadSQL);
        $this->enlazar(":usu", $usu);
        $fila = $this->fila();
        if ($fila) {
            // Comprobar el password
            if ($fila['password']!=$pass) {
                return null;
            }
        }
        return $fila;
    }
    // insertar realiza el insert con todos los datos del usuario que se hayan rellenado en el formulario de registro
    public function insertar($datos)
    {
        // Recibimos los datos del formulario en un array
        // Obtenemos cadena con las columnas desde las claves del array asociativo
        $columnas = implode(",", array_keys($datos));
        // Campos de columnas
        $campos = array_map(
            function ($col) {
                return ":" . $col;
            },
            array_keys($datos)
        );
        $parametros = implode(",", $campos); // Parametros para enlazar
        $cadSQL = "INSERT INTO usuarios ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    // activarCuenta es un metodo utilizado con PHPMailer para realizar la activación del usuario por correo
    // NO EN USO ACTUALMENTE
    public function activarCuenta($token)
    {
        // Activar la cuenta cuyo token sea el recibido como parametro
        $cadSQL = "UPDATE usuarios SET activo=1 WHERE token=:token";
        $this->consultar($cadSQL);
        $this->enlazar(":token", $token);
        return $this->ejecutar();
    }
    // existeUsuario se utiliza en el formulario para realizar las comprobaciones de user o email repetido
    public function existeUsuario($datos)
    {
        $clave = array_keys($datos)[0];
        $valor = array_values($datos)[0];
        $cadSQL = "SELECT count(*) as result FROM usuarios WHERE $clave  = '$valor'";
        //error_log($cadSQL);
        $this->consultar($cadSQL);
        return $this->fila()['result'];
    }
}
