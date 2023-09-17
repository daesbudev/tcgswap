<?php
// Coleccion_m es el modelo que gestiona todo lo relacionado con las colecciones de cartas de cada uno de los usuarios
class Coleccion_m extends Model
{
    public function __construct()
    {
        // Llamada al constructor del padre para conectar a la BBDD
        parent::__construct();
    }
    // insertarCarta es el metodo que realiza una insert de una carta con los datos proporcionados por el usuario dentro de su coleccion
    public function insertarCarta($datos)
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
        $cadSQL = "INSERT INTO coleccion_usu ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    // enColeccion comprueba que la carta añadida no se encuentre en la coleccion del usuario con las mismas caracteristicas para saber si debe añadirla o incrementar una ya existente
    public function enColeccion($usu, $car, $est, $idi)
    {
        $cadSQL = "SELECT * FROM coleccion_usu where id_usuario= :id_usu and id_carta= :id_car and estado= :est and idioma= :idi";
        $this->consultar($cadSQL);
        $this->enlazar(":id_usu", $usu);
        $this->enlazar(":id_car", $car);
        $this->enlazar(":est", $est);
        $this->enlazar(":idi", $idi);
        return $this->fila();
    }
    // modCarta es el metodo que se utiliza para hacer un update a la cantidad de una carta en una coleccion en caso de que esa carta ya existiera
    public function modCarta($datos)
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
        $cadSQL = "UPDATE coleccion_usu SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE id_entrada='$datos[id_entrada]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    public function borrarCarta()
    {
        $cadSQL = "DELETE FROM coleccion_usu WHERE id_entrada = :id_entrada";
        $this->consultar($cadSQL);
        $this->enlazar(":id_entrada", $_REQUEST['id_entrada']);
        return $this->ejecutar();
    }
    // cargarCartaColecciones es un metodo que se utiliza tanto en las vistas de las cartas como en las vistas de colecciones y su funcion es mostrar todas las cartas existentes
    // de una carta o de una coleccion en funcion de la informacion recibida de Ajax
    public function cargarCartaColecciones()
    {
        $cadSQL = "SELECT usuarios.id_usu as id_usu, usuarios.username as nombre_usu, cartas.id_carta as id_carta, cartas.nombre as nombre_carta, id_entrada, estado, idioma, cantidad 
        FROM coleccion_usu 
        INNER JOIN usuarios on coleccion_usu.id_usuario=usuarios.id_usu 
        INNER JOIN cartas on coleccion_usu.id_carta=cartas.id_carta where";
        // Llega desde la vista de la carta?
        if (!empty($_POST['id_carta'])) {
            $cadSQL .= " coleccion_usu.id_carta = :id_carta";
        }
        // Llega desde la vista de la coleccion de un usuario?
        if (!empty($_POST['id_user'])) {
            $cadSQL .= " coleccion_usu.id_usuario = :id_user";
        }
        // Params de los filtros
        if (!empty($_POST['nombre'])) {
            $cadSQL .= " and cartas.nombre LIKE :nombre";
        }
        if (!empty($_POST['estado'])) {
            $cadSQL .= " and coleccion_usu.estado = :estado";
        }
        if (!empty($_POST['idioma'])) {
            $cadSQL .= " and coleccion_usu.idioma = :idioma";
        }
        $this->consultar($cadSQL);
        if (!empty($_POST['id_carta'])) {
            $this->enlazar(":id_carta", $_POST['id_carta']);
        }
        if (!empty($_POST['id_user'])) {
            $this->enlazar(":id_user", $_POST['id_user']);
        }
        if (!empty($_POST['nombre'])) {
            $this->enlazar(":nombre", "%$_POST[nombre]%");
        }
        if (!empty($_POST['estado'])) {
            $this->enlazar(":estado", $_POST['estado']);
        }
        if (!empty($_POST['idioma'])) {
            $this->enlazar(":idioma", $_POST['idioma']);
        }
        return $this->resultado();
    }
}
