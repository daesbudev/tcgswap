<?php
// Carrito_m gestiona todo aquello relacionado con el CRUD del carrito de la compra del usuario
class Carrito_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // cartasEnCarrito obtiene la cantidad total de cartas que se encuentran en el carrito
    public function cartasEnCarrito()
    {
        $cadSQL = "SELECT sum(cantidad) as cantidad FROM carrito";
        $this->consultar($cadSQL);
        return $this->fila();
    }
    // leerTodo devuelve toda la informacion necesaria de las cartas que se encuentran en el carrito del usuario logeado
    public function leerTodo($usu)
    {
        $cadSQL = "SELECT usuarios.username as username, carrito.*, cartas.nombre as nombre_carta FROM `carrito` INNER JOIN usuarios on carrito.id_usu_carta=usuarios.id_usu INNER JOIN cartas on carrito.id_carta=cartas.id_carta WHERE id_usuario= :id_usu ORDER by id_usu_carta";
        $this->consultar($cadSQL);
        $this->enlazar(":id_usu", $usu);
        return $this->resultado();
    }
    // leerUsuAjax devuelve todas las cartas que tengas de un usuario en el carrito y se usa en la vista para formalizar un intercambio
    public function leerUsuAjax()
    {
        $cadSQL = "SELECT cartas.nombre as nombre_carta, carrito.id, carrito.id_carta, id_usu_carta, estado, idioma, cantidad from carrito INNER JOIN cartas on carrito.id_carta=cartas.id_carta where id_usu_carta= :id_user";
        $this->consultar($cadSQL);
        $this->enlazar(":id_user", $_POST['id_usu']);
        return $this->resultado();
    }
    public function leerUsuOferta($usu)
    {
        $cadSQL = "SELECT usuarios.username as username, carrito.*, cartas.nombre as nombre_carta FROM `carrito` INNER JOIN usuarios on carrito.id_usu_carta=usuarios.id_usu INNER JOIN cartas on carrito.id_carta=cartas.id_carta WHERE id_usu_carta= :id_usu";
        $this->consultar($cadSQL);
        $this->enlazar(":id_usu", $usu);
        return $this->resultado();
    }
    // leerCarta se utiliza en el controlador del carrito para comprobar si la carta con todos sus datos ya existe en el
    public function leerCarta($usuCar, $usu, $car, $est, $idi)
    {
        $cadSQL = "SELECT * FROM carrito WHERE id_usuario= :usu_car and id_usu_carta= :id_usu and id_carta= :id_car and estado= :est and idioma= :idi";
        $this->consultar($cadSQL);
        $this->enlazar(":usu_car", $usuCar);
        $this->enlazar(":id_usu", $usu);
        $this->enlazar(":id_car", $car);
        $this->enlazar(":est", $est);
        $this->enlazar(":idi", $idi);
        return $this->fila();
    }
    // insertarCarta añade al carrito la carta seleccionada en la vista correspondiente
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
        $cadSQL = "INSERT INTO carrito ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    // modificarCarta se encarga de modificar la cantidad de cartas en el carrito en caso de que la carta ya existiera con las mismas caracteristicas
    public function modificarCarta($datos)
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
        $cadSQL = "UPDATE carrito SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE id='$datos[id]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
    // vaciarCarritoUsu se encarga de borrar todas las cartas que el usuario logeado tenga en el carrito
    public function vaciarCarritoUsu($id_usu)
    {
        $cadSQL = "DELETE FROM carrito where id_usuario= :id_usu";
        $this->consultar($cadSQL);
        $this->enlazar(":id_usu", $id_usu);
        return $this->ejecutar();
    }
    // borrarLinea borra unicamente una carta que se encuentre en el carrito
    public function borrarLinea($id)
    {
        $cadSQL = "DELETE FROM carrito WHERE id= :id";
        $this->consultar($cadSQL);
        $this->enlazar(":id", $id);
        return $this->ejecutar();
    }
    // eliminarUsuCarrito borra todas aquellas cartas en el carrito que pertenezcan al id de usuario correspondiente.
    public function eliminarUsuCarrito($usu)
    {
        $cadSQL = "DELETE FROM carrito WHERE id_usu_carta= :id_usu";
        $this->consultar($cadSQL);
        $this->enlazar(":id_usu", $usu);
        return $this->ejecutar();
    }
}
