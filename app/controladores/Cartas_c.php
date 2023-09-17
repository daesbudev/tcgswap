<?php
// Controlador de cartas
class Cartas_c extends Controller
{
    private $cartas_m; // Modelo portal

    public function __construct()
    {
        // Instanciamos el modelo portal en la propiedad
        $this->cartas_m = $this->load_model("Cartas_m");
    }

    public function index()
    {
    }
    public function buscarCartas()
    {
        // metodo AJAX para el autocompletado del buscador
        // parametro unico: nombre de la carta
        $datos = $this->cartas_m->buscarCartas($_POST);
        echo json_encode($datos);
    }
    public function datosCarta($datos)
    {
        if (!$datos[0]) {
            $this->load_view("errorPagina");
        } else {
            $carta = $datos[0];
            // Recibo la carta y lo envio al modelo para sacar sus datos
            $datos['carta'] = $this->cartas_m->datosCarta($carta);
            // en caso de que no exista mando a error
            if (!$datos['carta']) {
                $this->load_view("errorPagina");
            } else {
                // si existe la muestro
                $titulo['nombre'] = str_replace("-", " ", $datos['carta']['nombre']);
                $contenido = "carta_v";
                $this->load_view("plantilla/cabecera", $titulo);
                $this->load_view($contenido, $datos);
                $this->load_view("plantilla/pie");
            }
        }
    }
}
