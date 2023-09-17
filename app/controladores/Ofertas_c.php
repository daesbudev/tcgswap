<?php
class Ofertas_c extends Controller
{
    private $ofertas_m;
    public function __construct()
    {
        $this->ofertas_m = $this->load_model("Ofertas_m");
    }
    public function index()
    {
    }
    // misOfertas se encarga de cargar la vista de los intercambios enviados y recibidos por el usuario
    public function misOfertas()
    {
        $titulo['nombre'] = "Intercambios";
        $contenido = "intercambios_v";
        $this->load_view("plantilla/cabecera", $titulo);
        $this->load_view($contenido);
        $this->load_view("plantilla/pie");
    }
    // detallesOferta se encarga de cargar la vista detallada de un intercambio
    public function detallesOferta($datos)
    {
        if (!$datos[0]) {
            $this->load_view("errorPagina");
        } else {
            $datos['oferta'] = $this->ofertas_m->leerOferta($datos[0]);
            // en caso de que no exista mando a error
            if (!$datos['oferta']) {
                $this->load_view("errorPagina");
            } else {
                // si existe la muestro
                $titulo['nombre'] = "Detalles de la oferta";
                $contenido = "detalles_oferta_v";
                $this->load_view("plantilla/cabecera", $titulo);
                $this->load_view($contenido, $datos);
                $this->load_view("plantilla/pie");
            }
        }
    }
    // enviarOferta se encarga de cargar la vista en la que se formaliza una oferta de intercambio
    public function enviarOferta($datos)
    {
        if (!$datos[0]) {
            $this->load_view("errorPagina");
        } else {
            $carrito_m = $this->load_model("Carrito_m");
            $datos['cartas'] = $carrito_m->leerUsuOferta($datos[0]);
            // en caso de que no exista mando a error
            if (!$datos['cartas']) {
                $this->load_view("errorPagina");
            } else {
                // si existe la muestro
                $titulo['nombre'] = "Enviar oferta";
                $contenido = "oferta_v";
                $this->load_view("plantilla/cabecera", $titulo);
                $this->load_view($contenido, $datos);
                $this->load_view("plantilla/pie");
            }
        }
    }
    // crearOferta se encarga de llamar al metodo para insertar una oferta cuando esta se envia
    public function crearOferta()
    {
        $datos['id_user_oferta'] = $_POST['id_user'];
        $datos['id_user_recibe'] = $_POST['id_usu_carta'];
        $datos['fecha_oferta'] = date("Y-m-d");
        $datos['status'] = "EN";
        $this->ofertas_m->crearOferta($datos);
        $_SESSION['exito'] = "¡La oferta ha sido enviada! Puedes revisarla en tu pestaña de intercambios";
    }
    // cargarOfertas se encarga de crear un JSON que contiene la informacion de las ofertas enviadas y recibidas del usuario logeado para tratarlo en la vista
    public function cargarOfertas()
    {
        $datos = $this->ofertas_m->cargarOfertas($_POST);
        echo json_encode($datos);
    }
    // leerCartasOferta se encarga de crear un JSON que contiene la informacion de las cartas dentro de una oferta para tratarlo en la vista
    public function leerCartasOferta()
    {
        $datos = $this->ofertas_m->leerCartasOferta($_POST);
        echo json_encode($datos);
    }
    // actualizarOferta se encarga de actualizar la oferta segun lo que reciba a traves del alert en la vista
    public function actualizarOferta()
    {
        $this->ofertas_m->actualizarOferta($_POST);
    }
}
