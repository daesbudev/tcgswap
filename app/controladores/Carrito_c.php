<?php
// Controlador de carrito 
class Carrito_c extends Controller
{
    private $carrito_m;
    // carga del modelo del carrito
    public function __construct()
    {
        $this->carrito_m = $this->load_model("Carrito_m");
    }
    // index lleva a la vista del carrito, donde podremos ver todas las cartas añadidas con la respectiva info del user al que pertenecen
    public function index()
    {
        //en caso de que alguien se salga del proceso de intercambio borramos todas las cartas cuyo id_usu_carta sea el mismo que el id de sesion
        echo $this->carrito_m->eliminarUsuCarrito($_SESSION['sesion']['id_usu']);
        $datos['items'] = $this->carrito_m->leerTodo($_SESSION['sesion']['id_usu']);
        $titulo['nombre'] = "Carrito";
        $contenido = "carrito_v";
        $this->load_view("plantilla/cabecera", $titulo);
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }
    // insertarCarta_ajax se encarga del evento de añadir las cartas al carrito cuando se pulsa el boton correspondiente
    public function insertarCarta_ajax()
    {
        // Recogemos los parametros para montar el array que enviaremos al metodo insertarCarta del modelo
        $datos = [
            "id_usuario" => $_REQUEST['id_usuario'],
            "id_usu_carta" => $_REQUEST['id_usu_carta'],
            "id_carta" => $_REQUEST['id_carta'],
            "estado" => $_REQUEST['estado'],
            "idioma" => $_REQUEST['idioma'],
            "cantidad" => 1
        ];
        // Comprobar que la carta no exista en el carrito
        $carta = $this->carrito_m->leerCarta($datos['id_usuario'], $datos['id_usu_carta'], $datos['id_carta'], $datos['estado'], $datos['idioma']);
        if ($carta) {
            // Modificar la cantidad de la carta en el carrito
            // En el array $carta tenemos lo que esta en el carrito
            $carta['cantidad'] += 1;
            $this->carrito_m->modificarCarta($carta);
        } else {
            // insertar el articulo en el carrito
            $this->carrito_m->insertarCarta($datos);
        }
    }
    // cartasEnCarrito llama al modelo para sacar el numero de cartas que se encuentran en el carrito
    public function cartasEnCarrito()
    {
        echo $this->carrito_m->cartasEnCarrito()['cantidad'];
    }
    // leerTodo llama al modelo, recoge toda la info del carrito y la codifica en formato JSON para tratarla en la vista
    public function leerTodo()
    {
        $articulos = $this->carrito_m->leerTodo();
        echo json_encode($articulos);
    }
    // vaciarCarrito llama al modelo y vacia todo el carrito de las cartas que contenga
    public function vaciarCarrito()
    {
        echo $this->carrito_m->vaciarCarrito();
    }
    // borrarLinea llama al modelo y borra la linea a partir del ID de carta que le llega
    public function borrarLinea()
    {
        echo $this->carrito_m->borrarLinea($_REQUEST['id']);
    }
    // eliminarUsuCarrito se encarga de borrar todas las cartas del carrito a partir del ID de usuario que le llega
    public function eliminarUsuCarrito()
    {
        echo $this->carrito_m->eliminarUsuCarrito($_REQUEST['id_usu_carta']);
    }
    // leerTodo llama al modelo, recoge toda la info de las cartas que se encuentran en el carrito y la codifica en formato JSON para tratarla en la vista
    public function leerUsuAjax(){
        $cartas = $this->carrito_m->leerUsuAjax($_POST);
        echo json_encode($cartas);
    }
}
