<?php
class Coleccion_c extends Controller
{
    private $coleccion_m;
    public function __construct()
    {
        $this->coleccion_m = $this->load_model("Coleccion_m");
    }
    public function index()
    {
    }
    // addCarta se ocupa de recoger la informacion dada por el usuario de una carta para añadirla a su coleccion
    public function addCarta()
    {
        // Recogemos los parametros necesarios para añadir la carta a la colección del usuario
        $datos = [
            "id_usuario" => $_SESSION['sesion']['id_usu'],
            "id_carta" => $_REQUEST['add_carta'],
            "estado" => $_REQUEST['add_estado'],
            "cantidad" => $_REQUEST['add_cantidad'],
            "idioma" => $_REQUEST['add_idioma']
        ];
        // ¿Ya existe este articulo con los mismos datos en la coleccion?
        $carta = $this->coleccion_m->enColeccion($datos['id_usuario'], $datos['id_carta'], $datos['estado'], $datos['idioma']);
        if ($carta) {
            $carta['cantidad'] += $datos['cantidad'];
            $this->coleccion_m->modCarta($carta);
        } else {
            // Si no, se introduce la carta en la coleccion
            $this->coleccion_m->insertarCarta($datos);
        }
        $_SESSION['exito'] = "¡La carta ha sido añadida a tu colección!";
        header("location:" . BASE_URL . "Cartas_c/datosCarta/" . $_REQUEST['add_nombre']);
    }
    // borrarCarta elimina una carta de la coleccion del usuario al que pertenece
    public function borrarCarta(){
        echo $this->coleccion_m->borrarCarta($_REQUEST['id_entrada']);
    }
    // listarCartaColecciones se encarga de llamar al metodo del modelo para cargar un listado de cartas en funcion de lo que llega a partir de Ajax
    public function listarCartaColecciones()
    {
        $datos = $this->coleccion_m->cargarCartaColecciones($_POST);
        echo json_encode($datos);
    }
}
