<?php
// el modelo Ofertas_m se encarga de gestionar todo lo relacionado con las ofertas entre usuarios
class Ofertas_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // leerOferta busca una oferta a partir de su ID y devuelve todos los datos relacionados con ella
    public function leerOferta($datos)
    {
        $cadSQL = "SELECT of.*, u1.username AS user1, u2.username AS user2 
        FROM oferta of 
        JOIN usuarios u1 ON of.id_user_oferta = u1.id_usu 
        JOIN usuarios u2 ON of.id_user_recibe = u2.id_usu 
        WHERE id_oferta= :id_oferta";
        $this->consultar($cadSQL);
        $this->enlazar("id_oferta", $datos);
        $fila = $this->fila();
        return $fila;
    }
    // misOfertas busca todas las ofertas en las cuales se encuentre el ID del usuario logeado, tanto las enviadas como las recibidas
    public function misOfertas()
    {
        $cadSQL = "SELECT * FROM oferta WHERE id_user_oferta= :id_usu OR id_user_recibe= :id_usu";
        $this->consultar($cadSQL);
        $this->enlazar("id_usu", $_SESSION['sesion']['id_usu']);
        return $this->resultado();
    }
    // crearOferta crea la oferta una vez el usuario completa el proceso de intercambio y llama al metodo que inserta las lineas del carrito a los articulos de la oferta
    public function crearOferta($datos)
    {
        //Leer último número de factura
        $datos['id_oferta'] = $this->ultimoNOferta() + 1;

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
        $cadSQL = "INSERT INTO oferta ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        $this->ejecutar();
        $this->insertarLineas($datos['id_oferta'], $datos['id_user_recibe']);
    }
    // usltimoNOferta busca cual es el ultimo numero de oferta
    private function ultimoNOferta()
    {
        $cadSQL = "SELECT MAX(id_oferta) as id_oferta from oferta";
        $this->consultar($cadSQL);
        return empty($this->fila()['id_oferta']) ? 0 : $this->fila()['id_oferta'];
    }
    // insertarLineas lee las lineas del carrito relacionadas con la oferta usando los ids de los usuarios y las inserta en articulos_oferta asociadas al id de la oferta
    private function insertarLineas($nofer, $userrecibe)
    {
        //Leer todo lo necesario  del carrito
        $cadSQL = "SELECT * FROM carrito where id_usuario= :id_usu and id_usu_carta = :id_usu or id_usu_carta = :id_recibe";
        $this->consultar($cadSQL);
        $this->enlazar("id_usu", $_SESSION['sesion']['id_usu']);
        $this->enlazar("id_recibe", $userrecibe);
        $carrito = $this->resultado();

        //bucle par cada linea del carrito->insertar en los articulos de la oferta
        foreach ($carrito as $linea) {
            $cadSQL = "INSERT INTO articulos_oferta VALUES (:id_of,:id_car,:id_user,:estado,:idioma,:cant)";
            $this->consultar($cadSQL);
            $this->enlazar(":id_of", $nofer);
            $this->enlazar(":id_car", $linea['id_carta']);
            $this->enlazar(":id_user", $linea['id_usu_carta']);
            $this->enlazar(":estado", $linea['estado']);
            $this->enlazar(":idioma", $linea['idioma']);
            $this->enlazar(":cant", $linea['cantidad']);
            $this->ejecutar();
        }
    }
    // cargarOfertas es usado en la vista para visualizar ofertas y distingue entre todas las ofertas, las enviadas o las recibidas por el usuario logeado
    public function cargarOfertas()
    {
        $cadSQL = "SELECT id_oferta, (select username from usuarios where id_usu=id_user_oferta) as usu_envia, (select username from usuarios where id_usu=id_user_recibe) as usu_recibe, fecha_oferta, oferta.status from oferta where";
        $this->consultar($cadSQL);
        // Solo las ofertas enviadas
        if (!empty($_POST['id_user_oferta']) && empty($_POST['id_user_recibe'])) {
            $cadSQL .= " id_user_oferta = :id_user ORDER BY fecha_oferta DESC";
        }
        // Solo las ofertas recibidas
        if (!empty($_POST['id_user_recibe']) && empty($_POST['id_user_oferta'])) {
            $cadSQL .= " id_user_recibe = :id_user ORDER BY fecha_oferta DESC";
        }
        // Todas
        if (!empty($_POST['id_user_oferta']) && !empty($_POST['id_user_recibe'])) {
            $cadSQL .= " id_user_oferta = :id_user or id_user_recibe = :id_user ORDER BY fecha_oferta DESC";
        }
        $this->consultar($cadSQL);
        if (!empty($_POST['id_user_oferta']) && empty($_POST['id_user_recibe'])) {
            $this->enlazar(":id_user", $_POST['id_user_oferta']);
        }
        // Solo las ofertas recibidas
        if (!empty($_POST['id_user_recibe']) && empty($_POST['id_user_oferta'])) {
            $this->enlazar(":id_user", $_POST['id_user_recibe']);
        }
        // Todas
        if (!empty($_POST['id_user_oferta']) && !empty($_POST['id_user_recibe'])) {
            $this->enlazar(":id_user", $_POST['id_user_oferta']);
        }
        return $this->resultado();
    }
    // leerCartasOferta devuelve todas las lineas relacionadas con los articulos que esten relacionados con la oferta que se haya cargado
    public function leerCartasOferta()
    {
        $cadSQL = "SELECT ao.*, c1.nombre as nombre_carta  
        FROM articulos_oferta ao
        JOIN cartas c1 ON ao.id_carta = c1.id_carta 
        WHERE id_user= :id_usu AND id_oferta= :id_oferta";
        $this->consultar($cadSQL);
        $this->enlazar("id_usu", $_POST['id_usu']);
        $this->enlazar("id_oferta", $_POST['id_oferta']);
        return $this->resultado();
    }
    // actualizarOferta cambia el estado de una oferta segun se envie un aceptar o un rechazar de parte del usuario que la recibe
    public function actualizarOferta(){
        $cadSQL = "UPDATE OFERTA SET status = :status WHERE id_oferta = :id_oferta";
        $this->consultar($cadSQL);
        $this->enlazar("status", $_POST['status']);
        $this->enlazar("id_oferta", $_POST['id_oferta']);
        return $this->ejecutar();
    }
}
